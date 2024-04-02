<?php include '../actions/fonctions/transfoGradeIntVersText.php'; ?>
<?php if(isset($_GET['s']) AND !empty($_GET['s'])){
        $s = $_GET['s'];

            $checkIfUserExists = $bdd->prepare('SELECT * FROM users WHERE id = ? ORDER BY id');
            $checkIfUserExists->execute(array($s));

            echo '<h3 id="id">Par ID :</h3>';
            while($users = $checkIfUserExists->fetch()){ ?>
            <div class="bordure">
                <h4><?= $users['prenom'] ?> <?= $users['nom'] ?></h4>
                <p>ID : <?= $users['id'] ?></p>
                <p>Carte : <?= $users['carte'] ?></p>
                <p>Classe : <?= $users['classe'] ?></p>
                <p>Nombre d'emprunt(s) : <?php echo '' . $users['nb_emprunt'] . '/' . $users['nb_emprunt_max'] . ''; ?></p>
                <p>Grade : <?php Grade($users['grade']); ?><br /></p>
                <p><a style="color: black;" href="update-user.php?id=<?= $users['id'] ?>">Modifier l'utilisateur</a></p>
            </div>
            <br />
            
<?php }
            $checkIfUserExists = $bdd->prepare('SELECT * FROM users WHERE nom = ? ORDER BY id');
            $checkIfUserExists->execute(array($s));

            echo '<h3 id="name">Par nom :</h3>';
            while($users = $checkIfUserExists->fetch()){ ?>
            <div class="bordure">
                <h4><?= $users['prenom'] ?> <?= $users['nom'] ?></h4>
                <p>ID : <?= $users['id'] ?></p>
                <p>Carte : <?= $users['carte'] ?></p>
                <p>Classe : <?= $users['classe'] ?></p>
                <p>Nombre d'emprunt(s) : <?php echo '' . $users['nb_emprunt'] . '/' . $users['nb_emprunt_max'] . ''; ?></p>
                <p>Grade : <?php Grade($users['grade']); ?><br /></p>
                <p><a style="color: black;" href="update-user.php?id=<?= $users['id'] ?>">Modifier l'utilisateur</a></p>
            </div>
            <br />
            
<?php }
            $checkIfUserExists = $bdd->prepare('SELECT * FROM users WHERE prenom = ? ORDER BY id');
            $checkIfUserExists->execute(array($s));

            echo '<h3 id="firstname">Par prénom :</h3>';
            while($users = $checkIfUserExists->fetch()){ ?>
            <div class="bordure">
                <h4><?= $users['prenom'] ?> <?= $users['nom'] ?></h4>
                <p>ID : <?= $users['id'] ?></p>
                <p>Carte : <?= $users['carte'] ?></p>
                <p>Classe : <?= $users['classe'] ?></p>
                <p>Nombre d'emprunt(s) : <?php echo '' . $users['nb_emprunt'] . '/' . $users['nb_emprunt_max'] . ''; ?></p>
                <p>Grade : <?php Grade($users['grade']); ?><br /></p>
                <p><a style="color: black;" href="update-user.php?id=<?= $users['id'] ?>">Modifier l'utilisateur</a></p>
            </div>
            <br />
            
<?php }
            $checkIfUserExists = $bdd->prepare('SELECT * FROM users WHERE carte = ? ORDER BY id');
            $checkIfUserExists->execute(array($s));

            echo '<h3 id="firstname">Par carte :</h3>';
            while($users = $checkIfUserExists->fetch()){ ?>
            <div class="bordure">
                <h4><?= $users['prenom'] ?> <?= $users['nom'] ?></h4>
                <p>ID : <?= $users['id'] ?></p>
                <p>Carte : <?= $users['carte'] ?></p>
                <p>Classe : <?= $users['classe'] ?></p>
                <p>Nombre d'emprunt(s) : <?php echo '' . $users['nb_emprunt'] . '/' . $users['nb_emprunt_max'] . ''; ?></p>
                <p>Grade : <?php Grade($users['grade']); ?><br /></p>
                <p><a style="color: black;" href="update-user.php?id=<?= $users['id'] ?>">Modifier l'utilisateur</a></p>
            </div>
            <br />

<?php }
        $checkIfUserExists = $bdd->prepare('SELECT * FROM users WHERE classe = ? ORDER BY id');
        $checkIfUserExists->execute(array($s));

        echo '<h3 id="firstname">Par classe :</h3>';
        while($users = $checkIfUserExists->fetch()){ ?>
        <div class="bordure">
            <h4><?= $users['prenom'] ?> <?= $users['nom'] ?></h4>
            <p>ID : <?= $users['id'] ?></p>
            <p>Carte : <?= $users['carte'] ?></p>
            <p>Classe : <?= $users['classe'] ?></p>
            <p>Nombre d'emprunt(s) : <?php echo '' . $users['nb_emprunt'] . '/' . $users['nb_emprunt_max'] . ''; ?></p>
            <p>Grade : <?php Grade($users['grade']); ?><br /></p>
            <p><a style="color: black;" href="update-user.php?id=<?= $users['id'] ?>">Modifier l'utilisateur</a></p>
        </div>
        <br />

<?php }
        if($s == 'Administrateur'){$s = '1';}elseif($s == 'Gérant(e) du C.D.I'){$s = '2';}elseif($s == 'Assistant(e) du C.D.I'){$s = '3';}elseif($s == 'Aucun'){$s = 0;}

        $checkIfUserExists = $bdd->prepare('SELECT * FROM users WHERE grade = ? ORDER BY id');
        $checkIfUserExists->execute(array($s));

        echo '<h3 id="firstname">Par grade :</h3>';
        while($users = $checkIfUserExists->fetch()){ ?>
        <div class="bordure">
            <h4><?= $users['prenom'] ?> <?= $users['nom'] ?></h4>
            <p>ID : <?= $users['id'] ?></p>
            <p>Carte : <?= $users['carte'] ?></p>
            <p>Classe : <?= $users['classe'] ?></p>
            <p>Nombre d'emprunt(s) : <?php echo '' . $users['nb_emprunt'] . '/' . $users['nb_emprunt_max'] . ''; ?></p>
            <p>Grade : <?php Grade($users['grade']); ?><br /></p>
            <p><a style="color: black;" href="update-user.php?id=<?= $users['id'] ?>">Modifier l'utilisateur</a></p>
        </div>
        <br />

<?php }
}