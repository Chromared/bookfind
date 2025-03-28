<?php
//This file belongs to the Bookfind project.
//
//Bookfind is distributed under the terms of the MIT software license.
//
//Copyright (C) 2025 Chromared
?>



<?php
if ((!isset($_GET['id'])) OR ($_GET['id'] != $_SESSION['id'])){
    header('index.php');
}