# X11 License
# Copyright © 2024 Chromared


<?php
session_start();
$_SESSION = [];
session_destroy();
header('Location: ../../login.php');