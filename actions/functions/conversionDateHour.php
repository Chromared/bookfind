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



<?php function ConversionDateHour($datehour) {
    // Attempt to convert the date/time
    $timestamp = strtotime($datehour);
    // If strtotime fails, the format is invalid
    if (!$timestamp) {
        echo bookfind_translate("Invalid date format");
    } else {
        // Display in d/m/Y format with time
        echo date("d/m/Y at H\hi", $timestamp);
    }
}