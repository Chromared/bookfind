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



<?php require_once ROOT_PATH . '/actions/functions/sessionInit.php';
$id = $_GET['id'] ?? null;
if (isset($_POST['validateGrade'])) {
    if ($_SESSION['grade'] == '1' or $_SESSION['grade'] == '2') {
        if (isset($_POST['grade'])) {
            if (!empty($_POST['grade']) or $_POST['grade'] == 0) {

                if (($_POST['grade'] == 1 and $_SESSION['grade'] == 1) or $_POST['grade'] != 1) {

                    $newGrade = $_POST['grade'];
                    $id = $_GET['id'];

                    $updateSchoolInfo = $db->prepare('UPDATE users SET grade = ? WHERE id = ?');
                    $updateSchoolInfo->execute(array($newGrade, $id));

                    // Retrieve user info for logging
                    $getUser = $db->prepare('SELECT id, first_name, last_name, grade FROM users WHERE id = ?');
                    $getUser->execute(array($id));
                    $usersInfos = $getUser->fetch();

                    SaveLog($db, $_SERVER['REQUEST_URI'], 'Grade changed', 'The grade of <a href="' . htmlspecialchars(url('profile.php?id=' . rawurlencode((string)($usersInfos['id'] ?? ''))), ENT_QUOTES, 'UTF-8') . '">' . htmlspecialchars($usersInfos['first_name'] ?? '') . ' ' . htmlspecialchars($usersInfos['last_name'] ?? '') . '</a> was changed from ' . NoEchoGrade($usersInfos['grade'] ?? '') . ' to ' . NoEchoGrade($newGrade) . '.');

                    header('Location: ' . url('gestion/update-user.php?id=' . rawurlencode((string)($id ?? '')) . '&msg5=true'));
                } else {
                    $errorMsg5 = bookfind_translate('You do not have sufficient permissions to apply this grade.');
                }
            } else {
                $errorMsg5 = bookfind_translate('Please fill in all fields.');
            }
        } else {
            $errorMsg5 = bookfind_translate('Not all fields exist. Please') . ' <a href="' . htmlspecialchars(url('gestion/update-user.php?id=' . rawurlencode((string)$id)), ENT_QUOTES, 'UTF-8') . '">' . bookfind_translate('reload') . '</a> ' . bookfind_translate('the page.');
        }
    } else {
        $errorMsg5 = bookfind_translate('You do not have permission to perform this action.');
    }
}
