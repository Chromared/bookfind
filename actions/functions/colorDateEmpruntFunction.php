<?php
//This file belongs to the BookFind project.
//
//BookFind is distributed under the terms of the MIT software license.
//
//Copyright (C) 2025 Chromared
?>



<?php
function ColorDateEmprunt($Date) {
    $Now = date("Y-m-d");

    switch (true) {
        case ($Date > $Now):
            echo '<span class="text-body">' . NoEchoConversionDate($Date) . '</span>';
            break;
        case ($Date == $Now):
            echo '<span style="color: green;">' . NoEchoConversionDate($Date) . '</span>';
            break;
        case ($Date < $Now):
            echo '<span style="color: red;">' . NoEchoConversionDate($Date) . '</span>';
            break;
    }
}
