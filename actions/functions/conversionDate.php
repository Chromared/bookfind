<?php
//This file belongs to the BookFind project.
//
//BookFind is distributed under the terms of the MIT software license.
//
//Copyright (C) 2025 Chromared
?>



<?php function ConversionDate($date) {
    // Attempt to convert the date
    $timestamp = strtotime($date);
    // If strtotime fails, the format is invalid
    if (!$timestamp) {
        echo "Format de date invalide";
    }

    // Output in French format (d/m/Y)
    echo date("d/m/Y", $timestamp);
}
function NoEchoConversionDate($date) {
    // Attempt to convert the date
    $timestamp = strtotime($date);
    // If strtotime fails, the format is invalid
    if (!$timestamp) {
        return "Format de date invalide";
    }

    // Return in French format (d/m/Y)
    return date("d/m/Y", $timestamp);
}