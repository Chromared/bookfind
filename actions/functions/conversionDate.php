<?php
//This file belongs to the BookFind project.
//
//BookFind is distributed under the terms of the GNU Affero General Public License v3.0.
//
//Copyright (C) 2025 Chromared
?>



<?php function ConversionDate($date) {
    // Attempt to convert the date
    $timestamp = strtotime($date);
    // If strtotime fails, the format is invalid
    if (!$timestamp) {
        echo "Invalid date format";
    }

    // Output in d/m/Y format
    echo date("d/m/Y", $timestamp);
}
function NoEchoConversionDate($date) {
    // Attempt to convert the date
    $timestamp = strtotime($date);
    // If strtotime fails, the format is invalid
    if (!$timestamp) {
        return "Invalid date format";
    }

    // Return in d/m/Y format
    return date("d/m/Y", $timestamp);
}