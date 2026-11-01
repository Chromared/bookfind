<?php
//This file belongs to the BookFind project.
/*
 * Automatic cleanup script for temporary CSV files
 * Removes files older than 24 hours
 */
?>

<?php require_once __DIR__ . '/../../../actions/functions/sessionInit.php';

/**
 * Automatic cleanup script for temporary CSV files
 * Deletes files older than 24 hours
 */

// Define temporary directory
 $tempDir = __DIR__ . '/../temp';

if (!is_dir($tempDir)) {
    exit('Temporary directory not found.');
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

// Optional logging
if ($deletedCount > 0) {
    error_log("Automatic cleanup: $deletedCount temporary CSV file(s) deleted");
}

exit("Cleanup complete: $deletedCount file(s) deleted.");

