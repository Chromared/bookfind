# This file belongs to the Bookfind project.
#
# Bookfind is distributed under the terms of the MIT software license.
#
# Copyright (C) 2024 Chromared


<?php
try
{
$bdd = new PDO('mysql:host=localhost;dbname=bookfind', 'root', '');
}
catch (Exception $e)
{
die('Erreur : ' . $e->getMessage());
}