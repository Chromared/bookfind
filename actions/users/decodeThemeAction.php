<?php if (isset($_SESSION['auth'])) {
    $theme = $_SESSION['theme'];
}else{
    $theme = "0";
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
