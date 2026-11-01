<?php
//This file belongs to the BookFind project.
//
//BookFind is distributed under the terms of the GNU Affero General Public License v3.0.
//
//Copyright (C) 2025 Chromared
?>



<?php
function Selected($a, $b) {

    if ($a == $b) {
        echo 'selected="selected"';
}
}

function SelectedWithoutEcho($a, $b) {

    if ($a == $b) {
        return 'selected="selected"';
}
}