<?php switch ($_SESSION['theme']) {
    case "0":
    echo "";
    break;

    case "1":
    echo "dark";
    break;

    default:
    echo "";
}
