<?php
//This file belongs to the Bookfind project.
//
//Bookfind is distributed under the terms of the MIT software license.
//
//Copyright (C) 2024 Chromared
?>



<?php
require_once '../actions/database.php';

$term = $_GET['term'] . '%';

$stmt = $pdo->prepare('SELECT nom FROM types WHERE name LIKE ?');
$stmt->execute([$term]);
$results = $stmt->fetchAll(PDO::FETCH_COLUMN);

echo json_encode($results);