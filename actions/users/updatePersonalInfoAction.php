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



<?php
if (isset($_POST['validatePersonalInfo'])) {
    if (isset($_POST['name']) and isset($_POST['firstname'])) {
        if (!empty($_POST['name']) and !empty($_POST['firstname'])) {
            $name = $_POST['name'];
            $firstname = $_POST['firstname'];
            $id = $_SESSION['id'];

            $updatePersonalInfo = $db->prepare('UPDATE users SET last_name = ?, first_name = ? WHERE id = ?');
            $updatePersonalInfo->execute(array($name, $firstname, $id));

            if ($name != $_SESSION['lastname'] and $firstname == $_SESSION['firstname']) {
                SaveLog($db, $_SERVER['REQUEST_URI'], 'Account modified', 'The new last name is ' . $name . '.');
            } elseif ($name == $_SESSION['lastname'] and $firstname != $_SESSION['firstname']) {
                SaveLog($db, $_SERVER['REQUEST_URI'], 'Account modified', 'The new first name is ' . $firstname . '.');
            } elseif ($name != $_SESSION['lastname'] and $firstname != $_SESSION['firstname']) {
                SaveLog($db, $_SERVER['REQUEST_URI'], 'Account modified', 'This user is now named ' . $name . ' ' . $firstname . '.');
            }

            $_SESSION['lastname'] = $name;
            $_SESSION['firstname'] = $firstname;

            header('Location: ' . url('updateProfile.php?id=' . rawurlencode((string)$id) . '&msg1=true'));
        } else {
            $errorMsg1 = bookfind_translate('Please fill in all fields.');
        }
    } else {
        $errorMsg1 = bookfind_translate('Not all fields exist. Please') . ' <a href="' . htmlspecialchars(url('updateProfile.php?id=' . rawurlencode((string)$id)), ENT_QUOTES, 'UTF-8') . '">' . bookfind_translate('reload') . '</a> ' . bookfind_translate('the page.');
    }
}
