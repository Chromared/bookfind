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



<?php require_once __DIR__ . '/../../../actions/functions/sessionInit.php';
$id = $_GET['id'] ?? null;
if (isset($_POST['validateSchoolInfo'])) {
    if ($_SESSION['grade'] == '1' or $_SESSION['grade'] == '2') {
        if (isset($_POST['class_name'])) {
            if (!empty(!empty($_POST['class_name']))) {

                $class_name = $_POST['class_name'];
                $id = $_GET['id'];

                $checkIfClassAlreadyExists = $db->prepare('SELECT name FROM classes WHERE name = ?');
                $checkIfClassAlreadyExists->execute(array($class_name));

                if ($checkIfClassAlreadyExists->rowCount() > 0) {

                    header('Location: update-user.php?id=' . $id . '&msg2=true');
                        $updateSchoolInfo = $db->prepare('UPDATE users SET class_name = ? WHERE id = ?');
                        $updateSchoolInfo->execute(array($class_name, $id));

                        // Retrieve info before change
                        $getUser = $db->prepare('SELECT id, first_name, last_name, class_name FROM users WHERE id = ?');
                        $getUser->execute(array($id));
                        $usersInfos = $getUser->fetch();

                        if ($class_name != ($usersInfos['class_name'] ?? '')) {
                            SaveLog($db, $_SERVER['REQUEST_URI'], 'Account modified', 'The class of <a href="../profile.php?id=' . ($usersInfos['id'] ?? '') . '">' . htmlspecialchars($usersInfos['first_name'] ?? '') . ' ' . htmlspecialchars($usersInfos['last_name'] ?? '') . '</a> was changed from ' . htmlspecialchars($usersInfos['class_name'] ?? '') . ' to ' . htmlspecialchars($class_name) . '.');
                        }

                        header('Location: update-user.php?id=' . $id . '&msg2=true');
                } else {
                    $errorMsg2 = bookfind_translate('The selected class does not exist.');
                }
            } else {
                $errorMsg2 = bookfind_translate('All fields must be filled in.');
            }
        } else {
            $errorMsg2 = bookfind_translate('Not all fields exist. Reload the page') . ' <a href="update-user.php?id=' . ($id ?? '') . '">' . bookfind_translate('here') . '</a>.';
        }
    } else {
        $errorMsg2 = bookfind_translate('You do not have permission to perform this action.');
    }
}
