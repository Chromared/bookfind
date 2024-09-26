<?php
if ((!isset($_GET['id'])) OR ($_GET['id'] != $_SESSION['id'])){
    header('index.php');
}