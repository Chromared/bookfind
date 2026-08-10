<?php
//This file belongs to the BookFind project.
/*
 * Automatic cleanup script for temporary CSV files
 * Removes files older than 24 hours
 */
?>

<?php require_once __DIR__ . '/../../../actions/functions/sessionInit.php';

/**
 * Script de nettoyage automatique des fichiers temporaires CSV
 * Supprime les fichiers de plus de 24 heures
 */

// Define temporary directory
 $tempDir = __DIR__ . '/../temp';

if (!is_dir($tempDir)) {
    exit('Dossier temporaire introuvable.');
}

// Retention duration: 24 hours (in seconds)
 $maxAge = 24 * 60 * 60;
$now = time();
$deletedCount = 0;

// Iterate files in temporary directory
 $files = glob($tempDir . '/csv_import_*.csv');

foreach ($files as $file) {
    // Check file age
    if (is_file($file)) {
        $fileAge = $now - filemtime($file);

        if ($fileAge > $maxAge) {
            if (@unlink($file)) {
                $deletedCount++;
            }
        }
    }
}

// Journalisation optionnelle
if ($deletedCount > 0) {
    error_log("Nettoyage automatique : $deletedCount fichier(s) CSV temporaire(s) supprimé(s)");
}

exit("Nettoyage terminé : $deletedCount fichier(s) supprimé(s).");

