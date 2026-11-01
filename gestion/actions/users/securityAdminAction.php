<?php
//This file belongs to the BookFind project.
//
//BookFind is distributed under the terms of the GNU Affero General Public License v3.0.
//
//Copyright (C) 2025 Chromared
?>



<?php require_once __DIR__ . '/../../../actions/functions/sessionInit.php';
if(!isset($_SESSION['grade']) OR $_SESSION['grade'] == '0'){
    http_response_code(403);
    require '../errors/403.php';
    exit;
}