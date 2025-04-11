<?php
//This file belongs to the Bookfind project.
//
//Bookfind is distributed under the terms of the MIT software license.
//
//Copyright (C) 2025 Chromared
?>



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

        echo '<div class="container mt-3">
                <div class="d-flex justify-content-center mt-4">
                  <div class="card text-center mb-3" style="width: 50rem;">
                    <div class="card-body">
                      <h5 class="card-title">' . $log['type'] . '</h5>
                      <h6 class="card-subtitle mb-2 text-body-secondary">' . $log['user_name'] . '</h6>
                      <p class="card-text">' . $log['comment'] . '</p>
                      <ul class="list-group list-group-flush">
                        <li class="list-group-item">Le ' . $dateFormattee . '</li>
                        <li class="list-group-item">' . $log['user_ip'] . '</li>
                        <li class="list-group-item"><a href="' . $log['page'] . '" class="card-link">' . $log['page'] . '</a></li>
                        <li class="list-group-item"><a href="../profil.php?id=' . $log['user_id'] . '" class="btn btn-primary">Voir l\'utilisateur</a></li>
                      </ul>
                    </div>
                  </div>
                </div>
              </div>';
    }