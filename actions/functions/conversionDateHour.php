<?php
//This file belongs to the Bookfind project.
//
//Bookfind is distributed under the terms of the MIT software license.
//
//Copyright (C) 2025 Chromared
?>



<?php function ConversionDateHour($datehour) {
    // On tente de convertir la date avec heure
    $timestamp = strtotime($datehour);

    // Si strtotime échoue, le format est invalide
    if (!$timestamp) {
        echo "Format de date invalide";
    } else {
        // Affichage au format français avec heure
        echo date("d/m/Y à H\hi", $timestamp);
    }
}