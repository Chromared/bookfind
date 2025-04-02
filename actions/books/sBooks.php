<?php
//This file belongs to the Bookfind project.
//
//Bookfind is distributed under the terms of the MIT software license.
//
//Copyright (C) 2025 Chromared
?>

<?php if(isset($_GET['s']) AND !empty($_GET['s'])){

        $s = $_GET['s'];
        $keywords = explode(' ', $s);
        $searchConditions = [];

        foreach ($keywords as $keyword) {
            $searchConditions[] = "(titre LIKE ? OR auteur LIKE ? OR isbn LIKE ? OR editeur LIKE ? OR genre LIKE ? OR type LIKE ? OR serie LIKE ? OR id_unique LIKE ?)";
        }

        $sql = 'SELECT * FROM books WHERE ' . implode(' AND ', $searchConditions) . ' ORDER BY titre';
        $recupBooks = $bdd->prepare($sql);
        $params = [];
        foreach ($keywords as $keyword) {
            $params = array_merge($params, array_fill(0, 8, "%$keyword%"));
        }
        $recupBooks->execute($params);

            if($recupBooks->rowCount() == 0){
                echo '<p>Aucun livre n\'a été trouvée.</p>';
            }elseif($recupBooks->rowCount() > 0){

            while($books = $recupBooks->fetch()){ 
            
            $recupEmprunts = $bdd->prepare('SELECT * FROM emprunts WHERE id_book = ?');
            $recupEmprunts->execute(array($books['id']));
            $emprunts = $recupEmprunts->fetch(); ?>
          <div class="d-flex justify-content-center mt-4">
            <div class="card text-center" style="width: 50rem;">
              <div class="card-body">
                <h5 class="card-title"><?= htmlspecialchars($books['titre']); ?></h5>
                <h6 class="card-subtitle mb-2 text-body-secondary"><?= htmlspecialchars($books['auteur']); ?></h6>
                <p class="card-text"><?= htmlspecialchars($books['resume']); ?></p>
                <?php if(!empty($books['serie'])){ ?><p class="card-text">Tome <?= htmlspecialchars($books['tome']); ?> de la série <?= htmlspecialchars($books['serie']); ?></p><?php } ?>
                <?php if($books['statut'] == 1){ ?>
                  <ul class="list-group list-group-flush">
                    <li class="list-group-item">Emprunté par <?= htmlspecialchars($emprunts['firstname_name']); ?></li>
                    <li class="list-group-item">Retour prévu le <?php ColorDateEmprunt($emprunts['date_futur_retour']); ?></li>
                  </ul>
                <?php } ?>
                <div class="btn-group" role="group">
                  <a href="<?php if(!isset($gestion)){ ?>gestion/<?php } ?>update-book.php?id=<?= htmlspecialchars($books['id']); ?>" class="btn btn-primary">Modifier</a>
                  <a href="books-reader.php?id=<?= htmlspecialchars($books['id']); ?>" class="btn btn-secondary">Voir</a>
                  <a href="<?php if(!isset($gestion)){ ?>gestion/<?php } ?>emprunt.php?id=<?= htmlspecialchars($books['id']); ?><?php if($books['statut'] == 1){ echo '&card=' . htmlspecialchars($emprunts['card_emprunteur']); } ?>" class="btn btn-success">Emprunt</a>
                </div>
              </div>
            </div>
          </div>
            <br />
            
<?php }}}
