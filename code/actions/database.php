<?php
try
{
$bdd = new PDO('mysql:host=localhost;dbname=bookfind', 'root', '');
}
catch (Exception $e)
{
die('Erreur : ' . $e->getMessage());
}
