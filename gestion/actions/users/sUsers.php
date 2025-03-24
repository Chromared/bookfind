<?php
//This file belongs to the Bookfind project.
//
//Bookfind is distributed under the terms of the MIT software license.
//
//Copyright (C) 2024 Chromared
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
            <div class="bordure" class="profil-part">
                <h4><?= htmlspecialchars($users['prenom']); ?> <?= htmlspecialchars($users['nom']); ?></h4>
                <p>ID : <?= htmlspecialchars($users['id']); ?></p>
                <p>Carte : <?= htmlspecialchars($users['carte']); ?></p>
                <p>Classe : <?= htmlspecialchars($users['classe']); ?></p>
                <p>Nombre d'emprunt(s) : <?= htmlspecialchars($users['nb_emprunt']) . '/' . htmlspecialchars($users['nb_emprunt_max']); ?></p>
                <p>Grade : <?= Grade($users['grade']); ?><br /></p>
                <div class="profil-part">
                <button onclick="window.open('../profil.php?id=<?= $users['id'] ?>', '_blank')">Voir le profil</button>
                <button onclick="window.open('update-user.php?id=<?= $users['id'] ?>', '_blank')">Modifier l'utilisateur</button>
                </div>
            </div>
            <br />
        <?php }}