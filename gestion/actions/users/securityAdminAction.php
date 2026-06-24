<?php
//This file belongs to the BookFind project.
//
//BookFind is distributed under the terms of the MIT software license.
//
//Copyright (C) 2025 Chromared
?>



<?php
if(!isset($_SESSION['grade']) OR $_SESSION['grade'] == '0'){
    http_response_code(403);
    require '../errors/403.php';
    exit;
}