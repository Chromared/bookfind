# X11 License
# 2024 Chromared


<?php
if ((!isset($_GET['id'])) OR ($_GET['id'] != $_SESSION['id'])){
    header('index.php');
}