<?php
function DateMois($date)
{
    switch ($date)
    {
    case '01':
    echo htmlspecialchars('Janvier');
    break;

    case '02':
    echo htmlspecialchars('Février');
    break;

    case '03':
    echo htmlspecialchars('Mars');
    break;

    case '04':
    echo htmlspecialchars('Avril');
    break;

    case '05':
    echo htmlspecialchars('Mai');
    break;

    case '06':
    echo htmlspecialchars('Juin');
    break;

    case '07':
    echo htmlspecialchars('Juillet');
    break;

    case '08':
    echo htmlspecialchars('Août');
    break;

    case '09':
    echo htmlspecialchars('Septembre');
    break;

    case '10':
    echo htmlspecialchars('Octobre');
    break;

    case '11':
    echo htmlspecialchars('Novembre');
    break;

    case '12':
    echo htmlspecialchars('Décembre');
    break;

    default:
    echo htmlspecialchars('?');
    }
}