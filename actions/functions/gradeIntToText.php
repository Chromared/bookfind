<?php
//This file belongs to the BookFind project.
//
//BookFind is distributed under the terms of the GNU Affero General Public License v3.0.
//
//Copyright (C) 2025 Chromared
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
