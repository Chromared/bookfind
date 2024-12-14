<?php
//This file belongs to the Bookfind project.
//
//Bookfind is distributed under the terms of the MIT software license.
//
//Copyright (C) 2024 Chromared
?>



<?php include '../actions/fonctions/transfoGradeIntVersText.php';

$colonnes_valides = ['id', 'carte', 'classe', 'nom', 'prenom', 'grade', 'nb_emprunt_max', 'nb_emprunt'];

if (isset($_GET['s']) && !empty($_GET['s']) && isset($_GET['where']) && !empty($_GET['where'])) {

    $s = htmlspecialchars($_GET['s']);
    $where = htmlspecialchars($_GET['where']);
    
    if (in_array($where, $colonnes_valides)) {
        
        $requete = "SELECT * FROM users WHERE $where = :value ORDER BY $where ASC";
        $SearchUser = $bdd->prepare($requete);
        
        $SearchUser->bindParam(':value', $s, PDO::PARAM_STR);
        $SearchUser->execute();
        
        while ($users = $SearchUser->fetch()) { ?>
            <div class="bordure" class="profil-part">
                <h4><?= htmlspecialchars($users['prenom']); ?> <?= htmlspecialchars($users['nom']); ?></h4>
                <p>ID : <?= htmlspecialchars($users['id']); ?></p>
                <p>Carte : <?= htmlspecialchars($users['carte']); ?></p>
                <p>Classe : <?= htmlspecialchars($users['classe']); ?></p>
                <p>Nombre d'emprunt(s) : <?= htmlspecialchars($users['nb_emprunt']) . '/' . htmlspecialchars($users['nb_emprunt_max']); ?></p>
                <p>Grade : <?= Grade($users['grade']); ?><br /></p>
                <div class="profil-part">
                <button onclick="window.open('../profil.php?id=<?= $users['id'] ?>', '_blank')">Voir le profil</button>
                <button onclick="window.open('update-user.php?id=<?= $users['id'] ?>', '_blank')">Modifier l'utilisateur'</button>
                </div>
            </div>
            <br />
        <?php }
        
    } else {
        echo "Erreur : Colonne non valide.";
    }
    
}