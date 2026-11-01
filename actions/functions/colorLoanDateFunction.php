<?php
//This file belongs to the BookFind project.
//
//BookFind is distributed under the terms of the GNU Affero General Public License v3.0.
//
//Copyright (C) 2025 Chromared
?>

<?php
function ColorLoanDate($Date) {
    $Now = date("Y-m-d");

    switch (true) {
        case ($Date > $Now):
            echo '<span class="text-muted">' . NoEchoConversionDate($Date) . '</span>';
            break;
        case ($Date == $Now):
            echo '<span class="text-success">' . NoEchoConversionDate($Date) . '</span>';
            break;
        case ($Date < $Now):
            echo '<span class="text-danger">' . NoEchoConversionDate($Date) . '</span>';
            break;
    }
}
