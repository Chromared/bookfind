<?php require_once '../../../actions/database.php';
    require_once '../../../actions/functions/conversionDateHour.php';

    $sevenDaysAgo = (new DateTime())->modify('-7 days')->format('Y-m-d H:i:s');
    $thirtyDaysAgo = (new DateTime())->modify('-30 days')->format('Y-m-d H:i:s');

    $query = $bdd->prepare("DELETE FROM logs WHERE (type = ? OR type = ? OR type = ?) AND datetime <= ?");
    $query->execute(['Connexion', 'Inscription', 'Déconnexion', $sevenDaysAgo]);

    $query = $bdd->prepare("DELETE FROM logs WHERE datetime <= ?");
    $query->execute([$thirtyDaysAgo]);

    $logs = $bdd->query('SELECT * FROM logs ORDER BY datetime DESC');

    while ($log = $logs->fetch())
    {
        $dateFormattee = date("d/m/Y à H:i:s", strtotime($log['datetime']));

        echo '<div class="loadLogs"><h2>' . $log['type'] . '</h2>
        <h4><a href="../profil.php?id=' . $log['user_id'] . '" target="_blank">' . $log['user_name'] . '</a> | ' . $log['user_ip'] . '</h4>
        <p><em><a id="aLogs" href="' . $log['page'] . '" target="_blank">' . $log['page'] . '</a></em></p>
        <p>' . $log['comment'] . '</p><p>Le ' . $dateFormattee . '</p></div><br />';
    }