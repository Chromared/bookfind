<?php
function ColorDateEmprunt($Date) {
    $Now = date("Y-m-d");

    switch (true) {
        case ($Date > $Now):
            echo '<span style="color: black;">' . NoEchoConversionDate($Date) . '</span>';
            break;
        case ($Date == $Now):
            echo '<span style="color: green;">' . NoEchoConversionDate($Date) . '</span>';
            break;
        case ($Date < $Now):
            echo '<span style="color: red;">' . NoEchoConversionDate($Date) . '</span>';
            break;
    }
}
