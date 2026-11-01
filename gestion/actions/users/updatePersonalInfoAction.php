<?php
//This file belongs to the BookFind project.
//
//BookFind is distributed under the terms of the GNU Affero General Public License v3.0.
//
//Copyright (C) 2025 Chromared
?>



<?php require_once __DIR__ . '/../../../actions/functions/sessionInit.php';
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
                    SaveLog($db, $_SERVER['REQUEST_URI'], 'Account modified', 'Last name changed for <a href="../profile.php?id=' . ($usersInfos['id'] ?? '') . '">' . htmlspecialchars($usersInfos['first_name'] ?? '') . ' ' . htmlspecialchars($usersInfos['last_name'] ?? '') . '</a> from ' . htmlspecialchars($usersInfos['last_name'] ?? '') . ' to ' . htmlspecialchars($name) . '.');
                } elseif ($name == ($usersInfos['last_name'] ?? '') and $firstname != ($usersInfos['first_name'] ?? '')) {
                    SaveLog($db, $_SERVER['REQUEST_URI'], 'Account modified', 'First name changed for <a href="../profile.php?id=' . ($usersInfos['id'] ?? '') . '">' . htmlspecialchars($usersInfos['first_name'] ?? '') . ' ' . htmlspecialchars($usersInfos['last_name'] ?? '') . '</a> from ' . htmlspecialchars($usersInfos['first_name'] ?? '') . ' to ' . htmlspecialchars($firstname) . '.');
                } elseif ($name != ($usersInfos['last_name'] ?? '') and $firstname != ($usersInfos['first_name'] ?? '')) {
                    SaveLog($db, $_SERVER['REQUEST_URI'], 'Account modified', 'First name and last name changed for <a href="../profile.php?id=' . ($usersInfos['id'] ?? '') . '">' . htmlspecialchars($usersInfos['first_name'] ?? '') . ' ' . htmlspecialchars($usersInfos['last_name'] ?? '') . '</a>. Their previous first name was ' . htmlspecialchars($usersInfos['first_name'] ?? '') . ' and is now ' . htmlspecialchars($firstname) . '. As for their last name, it changed from ' . htmlspecialchars($usersInfos['last_name'] ?? '') . ' to ' . htmlspecialchars($name) . '.');
                }

                header('Location: update-user.php?id=' . $id . '&msg1=true');
            } else {
                $errorMsg1 = 'Please fill in all fields.';
            }
        } else {
            $errorMsg1 = 'Not all fields exist. Please <a href="update-user.php?id=' . ($id ?? '') . '">reload</a> the page.';
        }
    } else {
        $errorMsg1 = 'You do not have permission to perform this action.';
    }
}
