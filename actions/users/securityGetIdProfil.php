# X11 License
# Copyright © 2024 Chromared


<?php
if ((!isset($_GET['id'])) OR ($_GET['id'] != $_SESSION['id'])){
    header('index.php');
}