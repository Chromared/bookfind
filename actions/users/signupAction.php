<?php
//This file belongs to the BookFind project.
//
//BookFind is distributed under the terms of the GNU Affero General Public License v3.0.
//
//Copyright (C) 2025 Chromared
?>



<?php
if (isset($_POST['validate'])) {
    if (isset($_POST['lastname']) and isset($_POST['firstname']) and isset($_POST['password']) and isset($_POST['confirm_password']) and isset($_POST['class_name'])) {
        if (!empty($_POST['lastname']) and !empty($_POST['firstname']) and !empty($_POST['password']) and !empty($_POST['confirm_password']) and !empty($_POST['class_name'])) {

            if ($_POST['password'] == $_POST['confirm_password']) {

                if (isset($_POST['rules-pdc'])) {

                    $lastname = $_POST['lastname'];
                    $firstname = $_POST['firstname'];
                    $password = password_hash($_POST['password'], PASSWORD_DEFAULT);
                    $class_name = $_POST['class_name'];

                    // Generate the username
                    $username = username($firstname, $lastname);

                    // Check if this username already exists in the database
                    $stmt = $db->prepare("SELECT COUNT(*) FROM users WHERE username LIKE ?");
                    $stmt->execute([$username . '%']);
                    $count = $stmt->fetchColumn();

                    // If the username already exists, add a number
                    if ($count > 0) {
                        $username .= ($count + 1);  // The number is based on the number of people already having this username
                    }

                    $checkIfClassAlreadyExists = $db->prepare('SELECT name FROM classes WHERE name = ?');
                    $checkIfClassAlreadyExists->execute(array($class_name));

                    if ($checkIfClassAlreadyExists->rowCount() > 0) {

                        $checkIfOneUserExist = $db->query('SELECT id FROM users');

                        if ($checkIfOneUserExist->rowCount() == 0) {
                            $grade = 1;
                        } else {
                            $grade = 0;
                        }

                        $insertUserOnWebsite = $db->prepare('INSERT INTO users SET username = ?, class_name = ?, last_name = ?, first_name = ?, password = ?, rules_accepted = ?, privacy_accepted = ?, grade = ?');
                        $insertUserOnWebsite->execute(array($username, $class_name, $lastname, $firstname, $password, true, true, $grade));

                        $getInfosOfThisUserReq = $db->prepare('SELECT * FROM users WHERE username = ?');
                        $getInfosOfThisUserReq->execute(array($username));

                        $usersInfos = $getInfosOfThisUserReq->fetch();

                        $_SESSION['auth'] = true;
                        $_SESSION['id'] = $usersInfos['id'];
                        $_SESSION['lastname'] = $usersInfos['last_name'];
                        $_SESSION['firstname'] = $usersInfos['first_name'];
                        $_SESSION['username'] = $usersInfos['username'];
                        $_SESSION['class_name'] = $usersInfos['class_name'];
                        $_SESSION['grade'] = $usersInfos['grade'];
                        $_SESSION['theme'] = $usersInfos['theme'];

                        SaveLog($db, $_SERVER['REQUEST_URI'], 'Sign up', 'No comment.');

                        header('Location: index.php?signup');
                    } else {
                        $errorMsg = 'The selected class does not exist.';
                    }
                } else {
                    $errorMsg = 'The terms of use and the rules must be accepted.';
                }
            } else {
                $errorMsg = 'The two passwords are not identical.';
            }
        } else {
            $errorMsg = 'Please fill in all fields.';
        }
    } else {
        $errorMsg = 'Not all fields exist. Please <a href="signup.php">reload</a> the page.';
    }
}
