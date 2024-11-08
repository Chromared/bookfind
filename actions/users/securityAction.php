# X11 License
# 2024 Chromared


<?php
session_start();
if(!isset($_SESSION['auth'])){
    header('Location: login.php');
}