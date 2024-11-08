# X11 License
# 2024 Chromared


<?php include '../actions/fonctions/transfoGradeIntVersText.php';

// Liste des colonnes valides pour la recherche
$colonnes_valides = ['id', 'carte', 'classe', 'nom', 'prenom', 'mdp', 'grade', 'datetime', 'regles', 'pdc', 'nb_emprunt_max', 'nb_emprunt'];

if (isset($_GET['s']) && !empty($_GET['s']) && isset($_GET['where']) && !empty($_GET['where'])) {

    $s = htmlspecialchars($_GET['s']);
    $where = htmlspecialchars($_GET['where']);
    
    // Valider que la colonne demandée est dans la liste des colonnes autorisées
    if (in_array($where, $colonnes_valides)) {
        
        // Préparer la requête SQL sécurisée
        $requete = "SELECT * FROM users WHERE $where = :value ORDER BY $where ASC";
        $SearchUser = $bdd->prepare($requete);
        
        // Lier la valeur de la recherche
        $SearchUser->bindParam(':value', $s, PDO::PARAM_STR);
        $SearchUser->execute();
        
        // Afficher les résultats
        while ($users = $SearchUser->fetch()) { ?>
            <div class="bordure">
                <h4><?= htmlspecialchars($users['prenom']); ?> <?= htmlspecialchars($users['nom']); ?></h4>
                <p>ID : <?= htmlspecialchars($users['id']); ?></p>
                <p>Carte : <?= htmlspecialchars($users['carte']); ?></p>
                <p>Classe : <?= htmlspecialchars($users['classe']); ?></p>
                <p>Nombre d'emprunt(s) : <?= htmlspecialchars($users['nb_emprunt']) . '/' . htmlspecialchars($users['nb_emprunt_max']); ?></p>
                <p>Grade : <?= Grade($users['grade']); ?><br /></p>
                <p><a style="color: black;" href="update-user.php?id=<?= htmlspecialchars($users['id']); ?>">Modifier l'utilisateur</a></p>
            </div>
            <br />
        <?php }
        
    } else {
        echo "Erreur : Colonne non valide.";
    }
    
}