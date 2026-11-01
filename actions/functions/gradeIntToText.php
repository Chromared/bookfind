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
    echo '<span class="badge badge--neutral">None</span>';
    break;

    case 1:
    echo '<span class="badge badge--danger">Administrator</span>';
    break;

    case 2:
    echo '<span class="badge badge--primary">Manager</span>';
    break;

    case 3:
    echo '<span class="badge badge--success">Assistant</span>';
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
    return 'None';

    case 1:
    return 'Administrator';

    case 2:
    return 'Manager';

    case 3:
    return 'Assistant';

    default:
    return '?';
    }
}
