<?php
require_once '../actions/database.php';

$term = $_GET['term'] . '%';

$stmt = $pdo->prepare('SELECT nom FROM authors WHERE name LIKE ?');
$stmt->execute([$term]);
$results = $stmt->fetchAll(PDO::FETCH_COLUMN);

echo json_encode($results);
?>
