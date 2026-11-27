<?php
//This file belongs to the BookFind project.
//Copyright (C) 2026 Chromared
//
//This program is free software: you can redistribute it and/or modify
//it under the terms of the GNU Affero General Public License as
//published by the Free Software Foundation, either version 3 of the
//License, or (at your option) any later version.
//
//This program is distributed in the hope that it will be useful,
//but WITHOUT ANY WARRANTY; without even the implied warranty of
//MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
//GNU Affero General Public License for more details.
//
//You should have received a copy of the GNU Affero General Public License
//along with this program.  If not, see <https://www.gnu.org/licenses/>.
?>



<?php function ConversionDate($date) {
    // Attempt to convert the date
    $timestamp = strtotime($date);
    // If strtotime fails, the format is invalid
    if (!$timestamp) {
        echo bookfind_translate("Invalid date format");
    }

    // Output in d/m/Y format
    echo date("d/m/Y", $timestamp);
}
function NoEchoConversionDate($date) {
    // Attempt to convert the date
    $timestamp = strtotime($date);
    // If strtotime fails, the format is invalid
    if (!$timestamp) {
        return "Invalid date format";
    }

    // Return in d/m/Y format
    return date("d/m/Y", $timestamp);
}