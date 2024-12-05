<?php
//This file belongs to the Bookfind project.
//
//Bookfind is distributed under the terms of the MIT software license.
//
//Copyright (C) 2024 Chromared
?>

<?php if(isset($_GET['s']) AND !empty($_GET['s'])){

        $s = $_GET['s'];
        $s = "%" . $s . "%";

        $recupBooks = $bdd->prepare('SELECT * FROM books WHERE titre LIKE ? ORDER BY titre');
        $recupBooks->execute([$s]);

            if($recupBooks->rowCount() == 0){
                echo '<p>Aucun livre n\'a été trouvée.</p>';
            }elseif($recupBooks->rowCount() > 0){

            while($books = $recupBooks->fetch()){ 
            
            $recupEmprunts = $bdd->prepare('SELECT * FROM emprunts WHERE id_book = ?');
            $recupEmprunts->execute(array($books['id']));
            $emprunts = $recupEmprunts->fetch(); ?>

            <div class="bordure">
                <h4><?= htmlspecialchars($books['titre']); ?></h4>
                <p>Auteur : <?= htmlspecialchars($books['auteur']); ?></p>
                <p>Résumé : <?php if(!empty($books['resume'])){ echo $books['resume']; }else{ echo 'Il n\'y a pas de résumé pour ce livre.'; } ?></p>
                <p><a style="color: black;" href="books-reader.php?id=<?= htmlspecialchars($books['id']); ?>">Voir le livre</a></p>
                <?php if(isset($_SESSION['auth'])){ if($_SESSION['grade'] != 0){
                         if($books['statut'] != 0){?>

                            <form method="get" action="<?php if(!isset($gestion)){ ?>gestion/<?php } ?>add-emprunt.php">
                                <input type="hidden" name="id" value="<?= htmlspecialchars($books['id']); ?>"/>
                                <input type="submit" value="Emprunter ce livre"/>
                            </form>
                    
                        <?php }elseif($books['statut'] == 1){?>

                            <p>Emprunté par : <?= htmlspecialchars($emprunts['firstname_name']); ?></p>
                            <p>Le : <?php ConversionDateHour($emprunts['date_emprunt']); ?></p>
                            <p>Retour prévu le : <?php ConversionDate($emprunts['date_retour']); ?></p>
                            <form method="get" action="<?php if(!isset($gestion)){ ?>gestion/<?php } ?>update-emprunt.php">
                                <input type="hidden" name="id" value="<?= htmlspecialchars($books['id']); ?>"/>
                                <input type="hidden" name="card" value="<?= htmlspecialchars($emprunts['card_emprunteur']); ?>"/>
                                <input type="submit" value="Modifier l'emprunt de ce livre"/>
                            </form>
                <?php }}} ?>
            </div>
            <br />
            
<?php }}
}else{

?>

<?php
}