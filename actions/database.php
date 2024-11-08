# X11 License
# Copyright © 2024 Chromared


<?php
try
{
$bdd = new PDO('mysql:host=localhost;dbname=bookfind', 'root', '');
}
catch (Exception $e)
{
die('Erreur : ' . $e->getMessage());
}