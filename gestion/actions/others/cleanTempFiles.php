<?php
/**
 * Script de nettoyage automatique des fichiers temporaires CSV
 * Supprime les fichiers de plus de 24 heures
 */

// Définir le dossier temporaire
$tempDir = __DIR__ . '/../temp';

if (!is_dir($tempDir)) {
    exit('Dossier temporaire introuvable.');
}

// Durée de rétention : 24 heures (en secondes)
$maxAge = 24 * 60 * 60;
$now = time();
$deletedCount = 0;

// Parcourir les fichiers du dossier temporaire
$files = glob($tempDir . '/csv_import_*.csv');

foreach ($files as $file) {
    // Vérifier l'âge du fichier
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

