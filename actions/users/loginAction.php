<?php
//This file belongs to the BookFind project.
//
//BookFind is distributed under the terms of the GNU Affero General Public License v3.0.
//
//Copyright (C) 2025 Chromared
?>



<?php
// Redirect after login: to the requested page if it is local,
// otherwise to the page matching the grade (management for graded users, home otherwise).
function loginRedirectTarget($url) {
    if (is_string($url) && $url !== '') {
        $url = html_entity_decode($url, ENT_QUOTES, 'UTF-8');
        // Only allow local redirects (avoids open redirects)
        if (!preg_match('#^(https?:)?//#i', $url)) {
            return $url;
        }
    }
    return (!empty($_SESSION['grade']) && $_SESSION['grade'] != '0') ? 'gestion/index.php' : 'index.php';
}

if (isset($_COOKIE['auth_token']) and !empty($_COOKIE['auth_token'])) {
    $token = $_COOKIE['auth_token'];
    $ip = $_SERVER['REMOTE_ADDR'];

    $checkIfTokenIsValid = $db->prepare('SELECT user_id FROM cookies WHERE token = ? AND user_ip = ?');
    $checkIfTokenIsValid->execute(array($token, $ip));

    if ($checkIfTokenIsValid->rowCount() > 0) {

        $usersID = $checkIfTokenIsValid->fetch();

        $updateLastUsed = $db->prepare('UPDATE cookies SET last_used = ? WHERE user_id = ?');
        $updateLastUsed->execute(array(date('Y-m-d H:i:s'), $usersID['user_id']));

        $checkIfUserAlreadyExists = $db->prepare('SELECT * FROM users WHERE id = ?');
        $checkIfUserAlreadyExists->execute(array($usersID['user_id']));

        $usersInfos = $checkIfUserAlreadyExists->fetch();

        $_SESSION['auth'] = true;
        $_SESSION['admin'] = false;
        $_SESSION['id'] = $usersInfos['id'];
        $_SESSION['lastname'] = $usersInfos['last_name'];
        $_SESSION['firstname'] = $usersInfos['first_name'];
        $_SESSION['username'] = $usersInfos['username'];
        $_SESSION['class_name'] = $usersInfos['class_name'];
        $_SESSION['grade'] = $usersInfos['grade'];
        $_SESSION['theme'] = $usersInfos['theme'];

        SaveLog($db, $_SERVER['REQUEST_URI'], 'Login', 'Automatic login via cookie.');

        header('Location: ' . loginRedirectTarget($_GET['redirect'] ?? ''));
        exit;
    }
} 
require_once __DIR__ . '/../functions/csrfFunction.php';

if (isset($_POST['validate'])) {
    // Verify CSRF token
    csrf_verify();

    // Anti-brute-force protections (by IP and session)
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
        $errorMsg = '<div class="msg"><div class="msg-alerte">Too many attempts. Try again later.</div></div>';
    }

    // reset window if expired
    if ((time() - $attempts['first']) >= 900) {
        $attempts = ['count' => 0, 'first' => time()];
    }

    // initializations
    $rememberMe = false;

    if (isset($_POST['username']) and isset($_POST['password'])) {
        if (!empty($_POST['username']) and !empty($_POST['password'])) {

            $username = $_POST['username'];
            $password = $_POST['password'];

            $checkIfUserAlreadyExists = $db->prepare('SELECT * FROM users WHERE username = ?');
            $checkIfUserAlreadyExists->execute(array($username));

            if ($checkIfUserAlreadyExists->rowCount() > 0) {

                $usersInfos = $checkIfUserAlreadyExists->fetch();

                if (password_verify($password, $usersInfos['password'])) {

                    if(isset($_POST['rememberMe']) and !empty($_POST['rememberMe'])) {

                        $rememberMe = true;

                        // generate a unique token
                        do {
                            $token = bin2hex(random_bytes(32));
                            $checkIfTokenAlreadyExists = $db->prepare('SELECT id FROM cookies WHERE token = ?');
                            $checkIfTokenAlreadyExists->execute(array($token));
                        } while ($checkIfTokenAlreadyExists->rowCount() > 0);
                        $ip = $_SERVER['REMOTE_ADDR'];
                        $userID = $usersInfos['id'];

                        $insertToken = $db->prepare('INSERT INTO cookies (user_id, token, user_ip, last_used) VALUES (?, ?, ?, ?)');
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
                    $_SESSION['lastname'] = $usersInfos['last_name'];
                    $_SESSION['firstname'] = $usersInfos['first_name'];
                    $_SESSION['username'] = $usersInfos['username'];
                    $_SESSION['class_name'] = $usersInfos['class_name'];
                    $_SESSION['grade'] = $usersInfos['grade'];
                    $_SESSION['theme'] = $usersInfos['theme'];

                    // Regenerate session ID to prevent fixation
                    session_regenerate_id(true);

                    // reset attempts on success
                    $attempts = ['count' => 0, 'first' => time()];

                    if($rememberMe) {
                        SaveLog($db, $_SERVER['REQUEST_URI'], 'Login', 'Manual login with cookie creation.');
                    } else {
                        SaveLog($db, $_SERVER['REQUEST_URI'], 'Login', 'Manual login.');
                    }


                    header('Location: ' . loginRedirectTarget($_POST['redirect'] ?? ''));
                    exit;
                } else {
                    // failure: increment counter and set generic message
                    $attempts['count']++;
                    $errorMsg = '<div class="msg"><div class="msg-alerte">Incorrect credentials.</div></div>';
                }
            } else {
                // failure: increment counter and set generic message
                $attempts['count']++;
                $errorMsg = '<div class="msg"><div class="msg-alerte">Incorrect credentials.</div></div>';
            }
        } else {
            $errorMsg = '<div class="msg"><div class="msg-alerte">Not all fields are filled in.</div></div>';
        }
    } else {
        $errorMsg = '<div class="msg"><div class="msg-alerte"><p>Not all fields exist. Reload the page by clicking <a href="login.php">here</a>.</p></div></div>';
    }
}
