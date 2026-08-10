<?php
//This file belongs to the BookFind project.
//
//BookFind is distributed under the terms of the MIT software license.
//
//Copyright (C) 2025 Chromared
?>



<?php require_once __DIR__ . '/../../../actions/functions/sessionInit.php'; if (isset($_POST['export'])) {
    // Clean output buffer to avoid unwanted newlines
    if (ob_get_length()) ob_clean();

    // Retrieve logs
    $req = $bdd->query("SELECT user_id, user_ip, user_card, user_name, type, comment, page, datetime FROM logs");
    $logs = $req->fetchAll(PDO::FETCH_ASSOC);

    // Check if logs exist
    if (empty($logs)) {
        die("Aucun log trouvé.");
    }

    // Set content type to CSV
    header('Content-Type: text/csv; charset=UTF-8');
    header('Content-Disposition: attachment; filename="logs_bookfind_' . time() . '.csv"');

    // Open output as stream
    $output = fopen('php://output', 'w');

    // Add BOM to avoid encoding issues with Excel
    fwrite($output, "\xEF\xBB\xBF");

    // Write CSV header
    fputcsv($output, array_keys($logs[0]));

    // Write log rows
    foreach ($logs as $log) {
        fputcsv($output, $log);
    }

    fclose($output);

    SaveLog($bdd, $_SERVER['REQUEST_URI'], 'Export des logs', 'S\'engage à respecter la réglementation RGPD et reconnait que les logs peuvent contenir des données personnelles.');

    exit();
}