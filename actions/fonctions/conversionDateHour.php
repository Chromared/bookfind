<?php
function ConversionDateHour($datehour) {

    // Expression régulière pour capturer une date/heure dans le format standard
    if (preg_match('/(\d{4})-(\d{2})-(\d{2}) (\d{2}):(\d{2}):\d{2}/', $datehour, $matches)) {
        $newDate = "{$matches[3]}/{$matches[2]}/{$matches[1]} à {$matches[4]}h{$matches[5]}";
        echo $newDate;
    } else {
        echo "Format de date invalide";
    }
}