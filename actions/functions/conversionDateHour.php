<?php
//This file belongs to the BookFind project.
//
//BookFind is distributed under the terms of the MIT software license.
//
//Copyright (C) 2025 Chromared
?>



<?php function ConversionDateHour($datehour) {
    // Attempt to convert the date/time
    $timestamp = strtotime($datehour);
    // If strtotime fails, the format is invalid
    if (!$timestamp) {
        echo "Format de date invalide";
    } else {
        // Display in French format with time
        echo date("d/m/Y à H\hi", $timestamp);
    }
}