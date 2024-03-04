<?php
function DateMois($date)
{
    switch ($date)
    {
    case '01':
    echo 'Janvier';
    break;

    case '02':
    echo 'Février';
    break;

    case '03':
    echo 'Mars';
    break;

    case '04':
    echo 'Avril';
    break;

    case '05':
    echo 'Mai';
    break;

    case '06':
    echo 'Juin';
    break;

    case '07':
    echo 'Juillet';
    break;

    case '08':
    echo 'Août';
    break;

    case '09':
    echo 'Septembre';
    break;

    case '10':
    echo 'Octobre';
    break;

    case '11':
    echo 'Novembre';
    break;

    case '12':
    echo 'Décembre';
    break;

    default:
    echo '?';
    }
}