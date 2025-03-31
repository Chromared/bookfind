<?php
//This file belongs to the Bookfind project.
//
//Bookfind is distributed under the terms of the MIT software license.
//
//Copyright (C) 2025 Chromared
?>



<?php function ConversionDate($date) {
    // On tente de convertir la date
    $timestamp = strtotime($date);

    // Si strtotime échoue, le format est invalide
    if (!$timestamp) {
        echo "Format de date invalide";
    }

    // On retourne au format français (d/m/Y)
    echo date("d/m/Y", $timestamp);
}
function NoEchoConversionDate($date) {
    // On tente de convertir la date
    $timestamp = strtotime($date);

    // Si strtotime échoue, le format est invalide
    if (!$timestamp) {
        return "Format de date invalide";
    }

    // On retourne au format français (d/m/Y)
    return date("d/m/Y", $timestamp);
}