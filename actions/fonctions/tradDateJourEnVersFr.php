<?php
function DateJour($date)
{
    switch ($date)
    {
    case 'Monday':
    echo htmlspecialchars('Lundi');
    break;

    case 'Tuesday':
    echo htmlspecialchars('Mardi');
    break;

    case 'Wednesday':
    echo htmlspecialchars('Mercredi');
    break;

    case 'Thursday':
    echo htmlspecialchars('Jeudi');
    break;

    case 'Friday':
    echo htmlspecialchars('Vendredi');
    break;

    case 'Saturday':
    echo htmlspecialchars('Samedi');
    break;

    case 'Sunday':
    echo htmlspecialchars('Dimanche');
    break;

    default:
    echo htmlspecialchars('?');
    }
}