<?php
//This file belongs to the Bookfind project.
//
//Bookfind is distributed under the terms of the MIT software license.
//
//Copyright (C) 2025 Chromared
?>



<?php if (isset($_COOKIE['auth_token']) and !empty($_COOKIE['auth_token'])) {
    $token = $_COOKIE['auth_token'];
    $ip = $_SERVER['REMOTE_ADDR'];

    $checkIfTokenIsValid = $bdd->prepare('SELECT user_id FROM cookies WHERE token = ? AND user_ip = ?');
    $checkIfTokenIsValid->execute(array($token, $ip));

    if ($checkIfTokenIsValid->rowCount() > 0) {

        $usersID = $checkIfTokenIsValid->fetch();

        $updateLastUsed = $bdd->prepare('UPDATE cookies SET last_used = ? WHERE user_id = ?');
        $updateLastUsed->execute(array(date('Y-m-d H:i:s'), $usersID['user_id']));

        $checkIfUserAlreadyExists = $bdd->prepare('SELECT * FROM users WHERE id = ?');
        $checkIfUserAlreadyExists->execute(array($usersID['user_id']));

        $usersInfos = $checkIfUserAlreadyExists->fetch();

        $_SESSION['auth'] = true;
        $_SESSION['admin'] = false;
        $_SESSION['id'] = $usersInfos['id'];
        $_SESSION['lastname'] = $usersInfos['nom'];
        $_SESSION['firstname'] = $usersInfos['prenom'];
        $_SESSION['username'] = $usersInfos['username'];
        $_SESSION['classe'] = $usersInfos['classe'];
        $_SESSION['grade'] = $usersInfos['grade'];
        $_SESSION['theme'] = $usersInfos['theme'];

        SaveLog($bdd, $_SERVER['REQUEST_URI'], 'Connexion', 'Connexion automatique via cookie.');

        if (isset($_GET['redirect']) and !empty($_GET['redirect'])) {
            header('Location: ' . htmlspecialchars($_GET['redirect']));
            exit;
        } else {
            header('Location: index.php');
            exit;
        }
    }
} 
if (isset($_POST['validate'])) {
    if (isset($_POST['username']) and isset($_POST['password'])) {
        if (!empty($_POST['username']) and !empty($_POST['password'])) {

            $username = $_POST['username'];
            $password = $_POST['password'];

            $checkIfUserAlreadyExists = $bdd->prepare('SELECT * FROM users WHERE username = ?');
            $checkIfUserAlreadyExists->execute(array($username));

            if ($checkIfUserAlreadyExists->rowCount() > 0) {

                $usersInfos = $checkIfUserAlreadyExists->fetch();

                if (password_verify($password, $usersInfos['mdp'])) {

                    if(isset($_POST['rememberMe']) and !empty($_POST['rememberMe'])) {

                        while($isTokenUnique = false) {
                            $token = bin2hex(random_bytes(32));

                            $checkIfTokenAlreadyExists = $bdd->prepare('SELECT id FROM cookies WHERE token = ?');
                            $checkIfTokenAlreadyExists->execute(array($token));

                            if ($checkIfTokenAlreadyExists->rowCount() > 0) {
                                $isTokenUnique = false;
                            }
                        }

                        $token = bin2hex(random_bytes(32));
                        $ip = $_SERVER['REMOTE_ADDR'];
                        $userID = $usersInfos['id'];

                        $insertToken = $bdd->prepare('INSERT INTO cookies (user_id, token, user_ip, last_used) VALUES (?, ?, ?, ?)');
                        $insertToken->execute(array($userID, $token, $ip, date('Y-m-d H:i:s')));

                        setcookie(
                            "auth_token",
                            $token,
                            [
                                "expires" => time() + 60 * 60 * 24 * 30, // 30 days
                                "path" => "/",
                                "secure" => true,     // HTTPS only
                                "httponly" => true,   // not accessible in JS
                                "samesite" => "Strict"
                            ]
                        );
                    }

                    $_SESSION['auth'] = true;
                    $_SESSION['admin'] = false;
                    $_SESSION['id'] = $usersInfos['id'];
                    $_SESSION['lastname'] = $usersInfos['nom'];
                    $_SESSION['firstname'] = $usersInfos['prenom'];
                    $_SESSION['username'] = $usersInfos['username'];
                    $_SESSION['classe'] = $usersInfos['classe'];
                    $_SESSION['grade'] = $usersInfos['grade'];
                    $_SESSION['theme'] = $usersInfos['theme'];

                    SaveLog($bdd, $_SERVER['REQUEST_URI'], 'Connexion', 'Connexion manuelle.');

                    if (isset($_POST['redirect']) and !empty($_POST['redirect'])) {
                        header('Location: ' . htmlspecialchars($_POST['redirect']));
                        exit;
                    } else {
                        header('Location: index.php');
                        exit;
                    }
                } else {
                    $errorMsg = '<div class="msg"><div class="msg-alerte">Mot de passe est incorrect.</div></div>';
                }
            } else {
                $errorMsg = '<div class="msg"><div class="msg-alerte">Aucun compte n\'est associé à ce nom d\'utilisateur. Créer mon compte <a href="signup.php">ici</a>.</div></div>';
            }
        } else {
            $errorMsg = '<div class="msg"><div class="msg-alerte">Tous les champs ne sont pas rempli.</div></div>';
        }
    } else {
        $errorMsg = '<div class="msg"><div class="msg-alerte"><p>Tous les champs n\'existe pas. Recharger la page en cliquant <a href="login.php">ici</a>.</p></div></div>';
    }
}
