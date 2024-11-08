# This file belongs to the Bookfind project.
#
# Bookfind is distributed under the terms of the MIT software license.
#
# Copyright (C) 2024 Chromared


<?php
session_start();
$_SESSION = [];
session_destroy();
header('Location: ../../login.php');