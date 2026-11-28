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
?>



<?php if (isset($_POST['validateDelete2'])) {
        require_once ROOT_PATH . '/actions/users/deleteUsersPreservingLoans.php';
        $id = (int)($_SESSION['id'] ?? 0);
        $deletedCount = deleteUsersPreservingLoans($db, [$id], true);

        if ($deletedCount === null) {
            $activeLoans = $db->prepare('SELECT COUNT(*) FROM loans WHERE borrower_id = ? AND status = 1');
            $activeLoans->execute([$id]);
            $errorMsg4 = sprintf(bookfind_translate('You must return all your loans before deleting your account. You currently have %d book(s) still on loan.'), (int)$activeLoans->fetchColumn());
        } elseif ($deletedCount > 0) {
            SaveLog($db, $_SERVER['REQUEST_URI'], 'Account deleted', 'No comment.');

            header('Location: ' . url('actions/users/logoutAction.php'));
            exit;
        }
}
