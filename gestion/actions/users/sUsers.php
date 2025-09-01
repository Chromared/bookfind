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
            $searchConditions[] = "(prenom LIKE ? OR nom LIKE ? OR username LIKE ? OR classe LIKE ? OR nb_emprunt LIKE ? OR grade LIKE ?)";
        }

        $sql = 'SELECT * FROM users WHERE ' . implode(' AND ', $searchConditions) . '';
        $sUsers = $bdd->prepare($sql);
        $params = [];
        foreach ($keywords as $keyword) {
            $params = array_merge($params, array_fill(0, 6, "%$keyword%"));
        }
        $sUsers->execute($params);
        
        while ($users = $sUsers->fetch()) { ?>
            <?php if($users['nb_emprunt'] == 1){$emprunts = 'emprunt';}else{$emprunts = 'emprunts';} ?>
            <div class="container mt-3">
              <div class="d-flex justify-content-center mt-4">
                <div class="card text-center mb-3" style="width: 50rem;">
                  <div class="card-body">
                    <h5 class="card-title"><?= htmlspecialchars($users['prenom']); ?> <?= htmlspecialchars($users['nom']); ?></h4></h5>
                    <h6 class="card-subtitle mb-2 text-body-secondary"><?= htmlspecialchars($users['username']); ?></h6>
                    <ul class="list-group list-group-flush">
                        <li class="list-group-item">ID n°<?= htmlspecialchars($users['id']); ?></li>
                        <li class="list-group-item"><?php if($users['classe'] === 'Aucune'){ ?>Ne fait partie d'aucune classe<?php }else{ ?>En classe de <?= htmlspecialchars($users['classe']); ?><?php } ?></li>
                        <?php if($users['nb_emprunt'] > 0){ ?>
                          <li class="list-group-item"><?= htmlspecialchars($users['nb_emprunt']) . ' ' . $emprunts . ' en cours sur ' . htmlspecialchars($users['nb_emprunt_max']); ?></li>
                        <?php } ?>
                        <li class="list-group-item">Grade : <?php Grade($users['grade']); ?></li>
                    </ul>
                    <div class="btn-group" role="group">
                      <a href="update-user.php?id=<?= $users['id'] ?>" class="btn btn-primary">Modifier</a>
                      <a href="../profil.php?id=<?= $users['id'] ?>" class="btn btn-secondary">Voir</a>
                      <a href="user-emprunts.php?id=<?= htmlspecialchars($users['id']) ?>" class="btn btn-success">Emprunts</a>
                    </div>
                  </div>
                </div>
              </div>
            </div>
            <br />
<?php }}