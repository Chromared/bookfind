<?php
//This file belongs to the Bookfind project.
//
//Bookfind is distributed under the terms of the MIT software license.
//
//Copyright (C) 2025 Chromared
?>



<?php
function Grade($grade)
{
    switch ($grade)
    {
    case 0:
    echo 'Aucun';
    break;

    case 1:
    echo '<span class="administrateur">Administrateur</span>';
    break;

    case 2:
    echo '<span class="gerant">Gérant</span>';
    break;

    case 3:
    echo '<span class="assistant">Assistant</span>';
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
    return 'Aucun';

    case 1:
    return 'Administrateur';

    case 2:
    return 'Gérant';

    case 3:
    return 'Assistant';

    default:
    return '?';
    }
}