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
if (isset($_POST['validatePersonalInfo'])) {
    if ($_SESSION['grade'] == '1' or $_SESSION['grade'] == '2') {
        if (isset($_POST['name']) and isset($_POST['firstname'])) {
            if (!empty($_POST['name']) and !empty($_POST['firstname'])) {
                $name = $_POST['name'];
                $firstname = $_POST['firstname'];
                $id = $_GET['id'];

                $updatePersonalInfo = $db->prepare('UPDATE users SET last_name = ?, first_name = ? WHERE id = ?');
                $updatePersonalInfo->execute(array($name, $firstname, $id));

                // Retrieve user information before change for logging
                $getUser = $db->prepare('SELECT id, first_name, last_name FROM users WHERE id = ?');
                $getUser->execute(array($id));
                $usersInfos = $getUser->fetch();

                if ($name != ($usersInfos['last_name'] ?? '') and $firstname == ($usersInfos['first_name'] ?? '')) {
                    SaveLog($db, $_SERVER['REQUEST_URI'], 'Account modified', 'Last name changed for <a href="' . htmlspecialchars(url('profile.php?id=' . rawurlencode((string)($usersInfos['id'] ?? ''))), ENT_QUOTES, 'UTF-8') . '">' . htmlspecialchars($usersInfos['first_name'] ?? '') . ' ' . htmlspecialchars($usersInfos['last_name'] ?? '') . '</a> from ' . htmlspecialchars($usersInfos['last_name'] ?? '') . ' to ' . htmlspecialchars($name) . '.');
                } elseif ($name == ($usersInfos['last_name'] ?? '') and $firstname != ($usersInfos['first_name'] ?? '')) {
                    SaveLog($db, $_SERVER['REQUEST_URI'], 'Account modified', 'First name changed for <a href="' . htmlspecialchars(url('profile.php?id=' . rawurlencode((string)($usersInfos['id'] ?? ''))), ENT_QUOTES, 'UTF-8') . '">' . htmlspecialchars($usersInfos['first_name'] ?? '') . ' ' . htmlspecialchars($usersInfos['last_name'] ?? '') . '</a> from ' . htmlspecialchars($usersInfos['first_name'] ?? '') . ' to ' . htmlspecialchars($firstname) . '.');
                } elseif ($name != ($usersInfos['last_name'] ?? '') and $firstname != ($usersInfos['first_name'] ?? '')) {
                    SaveLog($db, $_SERVER['REQUEST_URI'], 'Account modified', 'First name and last name changed for <a href="' . htmlspecialchars(url('profile.php?id=' . rawurlencode((string)($usersInfos['id'] ?? ''))), ENT_QUOTES, 'UTF-8') . '">' . htmlspecialchars($usersInfos['first_name'] ?? '') . ' ' . htmlspecialchars($usersInfos['last_name'] ?? '') . '</a>. Their previous first name was ' . htmlspecialchars($usersInfos['first_name'] ?? '') . ' and is now ' . htmlspecialchars($firstname) . '. As for their last name, it changed from ' . htmlspecialchars($usersInfos['last_name'] ?? '') . ' to ' . htmlspecialchars($name) . '.');
                }

                header('Location: ' . url('gestion/update-user.php?id=' . rawurlencode((string)$id) . '&msg1=true'));
            } else {
                $errorMsg1 = bookfind_translate('Please fill in all fields.');
            }
        } else {
            $errorMsg1 = bookfind_translate('Not all fields exist. Please') . ' <a href="' . htmlspecialchars(url('gestion/update-user.php?id=' . rawurlencode((string)($id ?? ''))), ENT_QUOTES, 'UTF-8') . '">' . bookfind_translate('reload') . '</a> ' . bookfind_translate('the page.');
        }
    } else {
        $errorMsg1 = bookfind_translate('You do not have permission to perform this action.');
    }
}
