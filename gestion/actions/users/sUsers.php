<?php
//This file belongs to the Bookfind project.
//
//Bookfind is distributed under the terms of the MIT software license.
//
//Copyright (C) 2025 Chromared
?>



<?php include '../actions/functions/transfoGradeIntVersText.php';

    if(isset($_GET['s']) AND !empty($_GET['s'])) {

        $s = $_GET['s'];
        $keywords = explode(' ', $s);
        $searchConditions = [];

        foreach ($keywords as $keyword) {
            $searchConditions[] = "(prenom LIKE ? OR nom LIKE ? OR carte LIKE ? OR classe LIKE ? OR nb_emprunt LIKE ? OR grade LIKE ?)";
        }

        $sql = 'SELECT * FROM users WHERE ' . implode(' AND ', $searchConditions) . '';
        $sUsers = $bdd->prepare($sql);
        $params = [];
        foreach ($keywords as $keyword) {
            $params = array_merge($params, array_fill(0, 6, "%$keyword%"));
        }
        $sUsers->execute($params);
        
        while ($users = $sUsers->fetch()) { ?>
            <div class="container mt-3">
              <div class="d-flex justify-content-center mt-4">
                <div class="card text-center mb-3" style="width: 50rem;">
                  <div class="card-body">
                    <h5 class="card-title"><?= htmlspecialchars($users['prenom']); ?> <?= htmlspecialchars($users['nom']); ?></h4></h5>
                    <h6 class="card-subtitle mb-2 text-body-secondary"><?= htmlspecialchars($users['carte']); ?></h6>
                    <ul class="list-group list-group-flush">
                        <li class="list-group-item">ID n°<?= htmlspecialchars($users['id']); ?></li>
                        <li class="list-group-item">En classe de <?= htmlspecialchars($users['classe']); ?></li>
                        <li class="list-group-item"><?= htmlspecialchars($users['nb_emprunt']) . ' emprunts en cours sur ' . htmlspecialchars($users['nb_emprunt_max']); ?></li>
                        <li class="list-group-item">Grade : <?php Grade($users['grade']); ?></li>
                    </ul>
                    <div class="btn-group" role="group">
                      <a href="update-user.php?id=<?= $users['id'] ?>" target="_blank" class="btn btn-primary">Modifier</a>
                      <a href="../profil.php?id=<?= $users['id'] ?>" target="_blank" class="btn btn-secondary">Voir</a>
                      <a href="user-emprunts.php?card=<?= htmlspecialchars($users['carte']) ?>" target="_blank" class="btn btn-success">Emprunts</a>
                    </div>
                  </div>
                </div>
              </div>
            </div>
            <br />
<?php }}