# X11 License
# Copyright © 2024 Chromared


<?php
function Grade($grade)
{
    switch ($grade)
    {
    case 0:
    echo htmlspecialchars('Aucun');
    break;

    case 1:
    echo '<span class="red strong">Administrateur</span>';
    break;

    case 2:
    echo '<span class="blue strong">Gérant</span>';
    break;

    case 3:
    echo '<span class="green strong">Assistant</span>';
    break;

    default:
    echo htmlspecialchars('?');
    }
}