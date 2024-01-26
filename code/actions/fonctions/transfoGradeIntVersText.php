<?php
function Grade($grade)
{
    switch ($grade)
    {
    case 0:
    echo 'Aucun';
    break;

    case 1:
    echo '<span class="red strong">Administrateur</span>';
    break;

    case 2:
    echo '<span class="blue strong">Gérant(e) du C.D.I</span>';
    break;

    case 3:
    echo '<span class="green strong">Assistant(e) du C.D.I</span>';
    break;

    default:
    echo '?';
    }
}
?>