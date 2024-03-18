<?php
if($_SESSION['admin'] != "true"){
    header('Location: ../admin.php');
}