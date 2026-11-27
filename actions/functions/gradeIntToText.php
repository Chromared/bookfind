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

<?php
function Grade($grade)
{
    switch ($grade)
    {
    case 0:
    echo '<span class="badge badge--neutral">' . bookfind_translate('None') . '</span>';
    break;

    case 1:
    echo '<span class="badge badge--danger">' . bookfind_translate('Administrator') . '</span>';
    break;

    case 2:
    echo '<span class="badge badge--primary">' . bookfind_translate('Manager') . '</span>';
    break;

    case 3:
    echo '<span class="badge badge--success">' . bookfind_translate('Assistant') . '</span>';
    break;

    default:
    echo '?';
    }
}
function NoEchoGrade($grade)
{
    switch ($grade)
    {
    case 0:
    return bookfind_translate('None');

    case 1:
    return bookfind_translate('Administrator');

    case 2:
    return bookfind_translate('Manager');

    case 3:
    return bookfind_translate('Assistant');

    default:
    return '?';
    }
}
