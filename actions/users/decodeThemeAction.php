<?php if (isset($_SESSION['auth'])) {
    $theme = $_SESSION['theme'];
}

switch ($theme) {
    case "0":
        echo "";
        break;

    case "1":
        echo "dark";
        break;

    default:
        echo "";
}
