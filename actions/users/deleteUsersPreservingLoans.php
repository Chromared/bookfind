<?php
//This file belongs to the BookFind project.
//Copyright (C) 2026 Chromared
//
//This program is free software: you can redistribute it and/or modify
//it under the terms of the GNU Affero General Public License as
//published by the Free Software Foundation, either version 3 of the
//License, or (at your option) any later version.
//
//This program is distributed in the hope that it will be useful,
//but WITHOUT ANY WARRANTY; without even the implied warranty of
//MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
//GNU Affero General Public License for more details.
//
//You should have received a copy of the GNU Affero General Public License
//along with this program.  If not, see <https://www.gnu.org/licenses/>.

function deleteUsersPreservingLoans(PDO $db, array $userIds, bool $requireNoActiveLoans = false): ?int
{
    $userIds = array_values(array_unique(array_filter(array_map('intval', $userIds), static function ($id) {
        return $id > 0;
    })));

    if ($userIds === []) {
        return 0;
    }

    $ownsTransaction = !$db->inTransaction();
    if ($ownsTransaction) {
        $db->beginTransaction();
    }

    try {
        $placeholders = implode(',', array_fill(0, count($userIds), '?'));

        if ($requireNoActiveLoans) {
            $activeLoans = $db->prepare("SELECT COUNT(*) FROM loans WHERE borrower_id IN ($placeholders) AND status = 1");
            $activeLoans->execute($userIds);
            if ((int)$activeLoans->fetchColumn() > 0) {
                if ($ownsTransaction) {
                    $db->rollBack();
                }
                return null;
            }
        }

        $updateLoans = $db->prepare("UPDATE loans SET borrower_name = 'Deleted user' WHERE borrower_id IN ($placeholders)");
        $updateLoans->execute($userIds);

        $deleteCookies = $db->prepare("DELETE FROM cookies WHERE user_id IN ($placeholders)");
        $deleteCookies->execute($userIds);

        $deleteUsers = $db->prepare("DELETE FROM users WHERE id IN ($placeholders)");
        $deleteUsers->execute($userIds);
        $deletedCount = $deleteUsers->rowCount();

        if ($ownsTransaction) {
            $db->commit();
        }

        return $deletedCount;
    } catch (Throwable $exception) {
        if ($ownsTransaction && $db->inTransaction()) {
            $db->rollBack();
        }
        throw $exception;
    }
}
