<?php
//This file belongs to the Bookfind project.
//
//Bookfind is distributed under the terms of the MIT software license.
//
//Copyright (C) 2025 Chromared
?>



<?php if (isset($_POST['export'])) {
    // Nettoyer la sortie pour éviter les sauts de ligne inutiles
    if (ob_get_length()) ob_clean();

    // Récupérer les logs
    $req = $bdd->query("SELECT user_id, user_ip, user_card, user_name, type, comment, page, datetime FROM logs");
    $logs = $req->fetchAll(PDO::FETCH_ASSOC);

    // Vérifier si des logs existent
    if (empty($logs)) {
        die("Aucun log trouvé.");
    }

    // Définir le type de contenu en CSV
    header('Content-Type: text/csv; charset=UTF-8');
    header('Content-Disposition: attachment; filename="logs_bookfind_' . time() . '.csv"');

    // Ouvrir la sortie en tant que flux
    $output = fopen('php://output', 'w');

    // Ajouter le BOM pour éviter les problèmes d'encodage avec Excel
    fwrite($output, "\xEF\xBB\xBF");

    // Écrire l'en-tête CSV
    fputcsv($output, array_keys($logs[0]));

    // Écrire les lignes de logs
    foreach ($logs as $log) {
        fputcsv($output, $log);
    }

    fclose($output);

    SaveLog($bdd, $_SERVER['REQUEST_URI'], 'Export des logs', 'S\'engage à respecter la réglementation RGPD et reconnait que les logs peuvent contenir des données personnelles.');

    exit();
}