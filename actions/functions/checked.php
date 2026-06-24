<?php
//This file belongs to the BookFind project.
//
//BookFind is distributed under the terms of the MIT software license.
//
//Copyright (C) 2025 Chromared
?>



<?php
function Checked($a, $b) {

    if ($a == $b) {
        echo 'checked="checked"';
}
}

function CheckedWithoutEcho($a, $b) {

    if ($a == $b) {
        return 'checked="checked"';
}
}