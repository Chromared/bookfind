<?php
function DateJour($date)
{
    switch ($date)
    {
    case 'Monday':
    echo 'Lundi';
    break;

    case 'Tuesday':
    echo 'Mardi';
    break;

    case 'Wednesday':
    echo 'Mercredi';
    break;

    case 'Thursday':
    echo 'Jeudi';
    break;

    case 'Friday':
    echo 'Vendredi';
    break;

    case 'Saturday':
    echo 'Samedi';
    break;

    case 'Sunday':
    echo 'Dimanche';
    break;

    default:
    echo '?';
    }
}