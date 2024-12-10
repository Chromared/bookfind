<?php include '../../../actions/database.php';
    include '../../../actions/fonctions/conversionDateHour.php';

    $logs = $bdd->query('SELECT * FROM logs ORDER BY datetime DESC');

    while ($log = $logs->fetch())
    {
        $dateFormattee = date("d/m/Y à H:i:s", strtotime($log['datetime']));

        echo '<h2>' . $log['type'] . '</h2><h3><a href="../profil.php?id=' . $log['user_id'] . '" target="_blank">' . $log['user_name'] . '</a></h3><em>' . $log['page'] . '</em><br /><br />' . $log['comment'] . '<br /><br />Le ' . $dateFormattee . '<br /><br /><br />';
    }