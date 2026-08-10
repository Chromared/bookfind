<?php
//This file belongs to the BookFind project.
//
//BookFind is distributed under the terms of the MIT software license.
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
require_once __DIR__ . '/../functions/csrfFunction.php';

if (isset($_POST['validate'])) {
    // Vérifier le jeton CSRF
    csrf_verify();

    // Protections anti-brute-force (par IP, session)
    $ip = $_SERVER['REMOTE_ADDR'] ?? 'unknown';
    if (!isset($_SESSION['login_attempts'])) {
        $_SESSION['login_attempts'] = [];
    }
    $key = 'ip_' . $ip;
    if (!isset($_SESSION['login_attempts'][$key])) {
        $_SESSION['login_attempts'][$key] = ['count' => 0, 'first' => time()];
    }
    $attempts = &$_SESSION['login_attempts'][$key];
    // window 15 minutes, max 5
    if ($attempts['count'] >= 5 && (time() - $attempts['first']) < 900) {
        $errorMsg = '<div class="msg"><div class="msg-alerte">Trop de tentatives. Réessayez plus tard.</div></div>';
    }

    // reset window if expired
    if ((time() - $attempts['first']) >= 900) {
        $attempts = ['count' => 0, 'first' => time()];
    }

    // initialisations
    $rememberMe = false;

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

                        $rememberMe = true;

                        // génère un token unique
                        do {
                            $token = bin2hex(random_bytes(32));
                            $checkIfTokenAlreadyExists = $bdd->prepare('SELECT id FROM cookies WHERE token = ?');
                            $checkIfTokenAlreadyExists->execute(array($token));
                        } while ($checkIfTokenAlreadyExists->rowCount() > 0);
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

                    // Regénérer l'ID de session pour éviter fixation
                    session_regenerate_id(true);

                    // reset attempts on succès
                    $attempts = ['count' => 0, 'first' => time()];

                    if($rememberMe) {
                        SaveLog($bdd, $_SERVER['REQUEST_URI'], 'Connexion', 'Connexion manuelle avec création d\'un cookie.');
                    } else {
                        SaveLog($bdd, $_SERVER['REQUEST_URI'], 'Connexion', 'Connexion manuelle.');
                    }


                    if (isset($_POST['redirect']) and !empty($_POST['redirect'])) {
                        header('Location: ' . htmlspecialchars($_POST['redirect']));
                        exit;
                    } else {
                        header('Location: index.php');
                        exit;
                    }
                } else {
                    // échec : incrémenter compteur et message générique
                    $attempts['count']++;
                    $errorMsg = '<div class="msg"><div class="msg-alerte">Identifiants incorrects.</div></div>';
                }
            } else {
                // échec : incrémenter compteur et message générique
                $attempts['count']++;
                $errorMsg = '<div class="msg"><div class="msg-alerte">Identifiants incorrects.</div></div>';
            }
        } else {
            $errorMsg = '<div class="msg"><div class="msg-alerte">Tous les champs ne sont pas rempli.</div></div>';
        }
    } else {
        $errorMsg = '<div class="msg"><div class="msg-alerte"><p>Tous les champs n\'existe pas. Recharger la page en cliquant <a href="login.php">ici</a>.</p></div></div>';
    }
}
