# X11 License
# 2024 Chromared


<?php function ConversionDate($date) {

// Expression régulière pour capturer la date
if (preg_match('/(\d{4})-(\d{2})-(\d{2})/', $date, $matches)) {
    $newDate = "{$matches[3]}/{$matches[2]}/{$matches[1]}";
    echo $newDate;  // Affiche : 27/10/2024
} else {
    echo "Format de date invalide";
}
}