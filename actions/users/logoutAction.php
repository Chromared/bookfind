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



<?php require '../database.php';
require '../functions/logFunction.php';
require_once __DIR__ . '/../functions/sessionInit.php';

$deleteCookies = $db->prepare('DELETE FROM cookies WHERE user_id = ?');
$deleteCookies->execute(array($_SESSION['id']));

SaveLog($db, $_SERVER['REQUEST_URI'], 'Logout', 'No comment.');

$_SESSION = [];
session_destroy();
setcookie(
    "auth_token",
    "",
    [
        "expires" => time() - 3600,
        "path" => "/",
        "secure" => true,
        "httponly" => true,
        "samesite" => "Strict"
    ]
);

header('Location: ../../index.php');
