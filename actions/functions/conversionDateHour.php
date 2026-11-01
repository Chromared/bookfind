<?php
//This file belongs to the BookFind project.
//
//BookFind is distributed under the terms of the GNU Affero General Public License v3.0.
//
//Copyright (C) 2025 Chromared
?>



<?php function ConversionDateHour($datehour) {
    // Attempt to convert the date/time
    $timestamp = strtotime($datehour);
    // If strtotime fails, the format is invalid
    if (!$timestamp) {
        echo "Invalid date format";
    } else {
        // Display in d/m/Y format with time
        echo date("d/m/Y at H\hi", $timestamp);
    }
}