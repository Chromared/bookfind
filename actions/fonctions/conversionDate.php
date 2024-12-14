<?php
//This file belongs to the Bookfind project.
//
//Bookfind is distributed under the terms of the MIT software license.
//
//Copyright (C) 2024 Chromared
?>



<?php function ConversionDate($date) {

if (preg_match('/(\d{4})-(\d{2})-(\d{2})/', $date, $matches)) {
    $newDate = "{$matches[3]}/{$matches[2]}/{$matches[1]}";
    echo $newDate;
} else {
    echo "Format de date invalide";
}
}