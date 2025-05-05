<?php
//This file belongs to the Bookfind project.
//
//Bookfind is distributed under the terms of the MIT software license.
//
//Copyright (C) 2025 Chromared
?>

<?php require 'actions/database.php';
    require 'actions/users/securityAction.php';
    require 'actions/books/showEmprunts.php';
    require 'actions/functions/conversionDateHour.php';
    require 'actions/functions/conversionDate.php';
    require 'actions/functions/colorDateEmpruntFunction.php'; ?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Emprunts</title>
    <?php include 'includes/header.php'; ?>
</head>
<body>
<?php include 'includes/navbar.php'; ?>
<?php if (isset($_GET['card']) AND !empty($_GET['card'])){ ?>

    <?php $nbRetards = $selectInfosFromEmprunts1->rowCount();
        $nbAujourdhui = $selectInfosFromEmprunts2->rowCount();
        $nbEnCours = $selectInfosFromEmprunts3->rowCount();
        $nbRetournes = $selectInfosFromEmprunts4->rowCount(); ?>

    <div class="container mt-3">
      <div class="d-flex justify-content-center mt-4">
        <ul class="nav nav-tabs" id="myTab" role="tablist">
          <li class="nav-item" role="presentation">
            <button class="nav-link <?php if($nbRetards > 0){ echo 'active'; } ?>" id="retard-tab" data-bs-toggle="tab" data-bs-target="#retard" type="button" role="tab" aria-controls="retard" aria-selected="<?php if($nbRetards > 0){ echo 'true'; }else{ echo 'false'; } ?>" <?php if($nbRetards == 0){ echo 'disabled'; } ?>>En retard</button>
          </li>
          <li class="nav-item" role="presentation">
            <button class="nav-link <?php if($nbRetards == 0 AND $nbAujourdhui > 0){ echo 'active'; } ?>" id="aujourdhui-tab" data-bs-toggle="tab" data-bs-target="#aujourdhui" type="button" role="tab" aria-controls="aujourdhui" aria-selected="<?php if($nbRetards == 0 AND $nbAujourdhui > 0){ echo 'true'; }else{ echo 'false'; } ?>" <?php if($nbAujourdhui == 0){ echo 'disabled'; } ?>>À rendre aujourd'hui</button>
          </li>
          <li class="nav-item" role="presentation">
            <button class="nav-link <?php if($nbRetards == 0 AND $nbAujourdhui == 0 AND $nbEnCours > 0){ echo 'active'; } ?>" id="encours-tab" data-bs-toggle="tab" data-bs-target="#encours" type="button" role="tab" aria-controls="encours" aria-selected="<?php if($nbRetards == 0 AND $nbAujourdhui == 0 AND $nbEnCours > 0){ echo 'true'; }else{ echo 'false'; } ?>" <?php if($nbEnCours == 0){ echo 'disabled'; } ?>>En cours</button>
          </li>
          <li class="nav-item" role="presentation">
            <button class="nav-link <?php if($nbRetards == 0 AND $nbAujourdhui == 0 AND $nbEnCours == 0 AND $nbRetournes > 0){ echo 'active'; } ?>" id="retournes-tab" data-bs-toggle="tab" data-bs-target="#retournes" type="button" role="tab" aria-controls="retournes" aria-selected="<?php if($nbRetards == 0 AND $nbAujourdhui == 0 AND $nbEnCours == 0 AND $nbRetournes > 0){ echo 'true'; }else{ echo 'false'; } ?>" <?php if($nbRetournes == 0){ echo 'disabled'; } ?>>Retournés</button>
          </li>
        </ul>
      </div>
    </div>

    <div class="tab-content" id="myTabContent">
      <div class="tab-pane fade <?php if($nbRetards > 0){ echo 'show active'; } ?>" id="retard" role="tabpanel" tabindex="0">
        <?php if($selectInfosFromEmprunts1->rowCount() > 0){
            while($empruntsInfos1 = $selectInfosFromEmprunts1->fetch()){

                $selectInfosFromBooksEmprunts1 = $bdd->prepare('SELECT * FROM books WHERE id = ?');
                $selectInfosFromBooksEmprunts1->execute(array($empruntsInfos1['id_book']));
                $recupBooks = $selectInfosFromBooksEmprunts1->fetch(); ?>   
                    <div class="container mt-3">
                      <div class="d-flex justify-content-center mt-4">
                        <div class="card text-center" style="width: 50rem;">
                          <div class="card-body">
                            <h5 class="card-title"><?= htmlspecialchars($recupBooks['titre']); ?></h5>
                            <h6 class="card-subtitle mb-2 text-body-secondary"><?= htmlspecialchars($recupBooks['auteur']); ?></h6>
                            <ul class="list-group list-group-flush">
                              <li class="list-group-item">Emprunté le <?php ConversionDateHour($empruntsInfos1['date_emprunt']); ?></li>
                              <li class="list-group-item">Retour prévu le <?php ColorDateEmprunt($empruntsInfos1['date_futur_retour']); ?></li>
                            </ul>
                            <div class="btn-group" role="group">
                            <a href="books-reader.php?id=<?= htmlspecialchars($recupBooks['id']); ?>" class="btn btn-secondary">Voir</a>
                            <?php if($_SESSION['grade'] == 1){ ?><a href="gestion/emprunt.php?id=<?= htmlspecialchars($recupBooks['id']); ?><?php if($recupBooks['statut'] == 1){ echo '&card=' . htmlspecialchars($empruntsInfos1['card_emprunteur']); } ?>" class="btn btn-success">Emprunt</a><?php } ?>
                            </div>
                          </div>
                        </div>
                      </div>
                    </div>    
        <?php }} ?>
      </div>
      <div class="tab-pane fade <?php if($nbRetards == 0 AND $nbAujourdhui > 0){ echo 'show active'; } ?>" id="aujourdhui" role="tabpanel" tabindex="0">
        <?php if($selectInfosFromEmprunts2->rowCount() > 0){
            while($empruntsInfos2 = $selectInfosFromEmprunts2->fetch()){

                $selectInfosFromBooksEmprunts2 = $bdd->prepare('SELECT * FROM books WHERE id = ?');
                $selectInfosFromBooksEmprunts2->execute(array($empruntsInfos2['id_book']));
                $recupBooks = $selectInfosFromBooksEmprunts2->fetch(); ?>   
                    <div class="container mt-3">
                      <div class="d-flex justify-content-center mt-4">
                        <div class="card text-center" style="width: 50rem;">
                          <div class="card-body">
                            <h5 class="card-title"><?= htmlspecialchars($recupBooks['titre']); ?></h5>
                            <h6 class="card-subtitle mb-2 text-body-secondary"><?= htmlspecialchars($recupBooks['auteur']); ?></h6>
                            <ul class="list-group list-group-flush">
                              <li class="list-group-item">Emprunté le <?php ConversionDateHour($empruntsInfos2['date_emprunt']); ?></li>
                              <li class="list-group-item">Retour prévu le <?php ColorDateEmprunt($empruntsInfos2['date_futur_retour']); ?></li>
                            </ul>
                            <div class="btn-group" role="group">
                            <a href="books-reader.php?id=<?= htmlspecialchars($recupBooks['id']); ?>" class="btn btn-secondary">Voir</a>
                            <?php if($_SESSION['grade'] == 1){ ?><a href="gestion/emprunt.php?id=<?= htmlspecialchars($recupBooks['id']); ?><?php if($recupBooks['statut'] == 1){ echo '&card=' . htmlspecialchars($empruntsInfos2['card_emprunteur']); } ?>" class="btn btn-success">Emprunt</a><?php } ?>
                            </div>
                          </div>
                        </div>
                      </div>
                    </div>    
        <?php }} ?>
      </div>
      <div class="tab-pane fade <?php if($nbRetards == 0 AND $nbAujourdhui == 0 AND $nbEnCours > 0){ echo 'show active'; } ?>" id="encours" role="tabpanel" tabindex="0">
        <?php if($selectInfosFromEmprunts3->rowCount() > 0){
            while($empruntsInfos3 = $selectInfosFromEmprunts3->fetch()){

                $selectInfosFromBooksEmprunts3 = $bdd->prepare('SELECT * FROM books WHERE id = ?');
                $selectInfosFromBooksEmprunts3->execute(array($empruntsInfos3['id_book']));
                $recupBooks = $selectInfosFromBooksEmprunts3->fetch(); ?>   
                    <div class="container mt-3">
                      <div class="d-flex justify-content-center mt-4">
                        <div class="card text-center" style="width: 50rem;">
                          <div class="card-body">
                            <h5 class="card-title"><?= htmlspecialchars($recupBooks['titre']); ?></h5>
                            <h6 class="card-subtitle mb-2 text-body-secondary"><?= htmlspecialchars($recupBooks['auteur']); ?></h6>
                            <ul class="list-group list-group-flush">
                              <li class="list-group-item">Emprunté le <?php ConversionDateHour($empruntsInfos3['date_emprunt']); ?></li>
                              <li class="list-group-item">Retour prévu le <?php ColorDateEmprunt($empruntsInfos3['date_futur_retour']); ?></li>
                            </ul>
                            <div class="btn-group" role="group">
                            <a href="books-reader.php?id=<?= htmlspecialchars($recupBooks['id']); ?>" class="btn btn-secondary">Voir</a>
                            <?php if($_SESSION['grade'] == 1){ ?><a href="gestion/emprunt.php?id=<?= htmlspecialchars($recupBooks['id']); ?><?php if($recupBooks['statut'] == 1){ echo '&card=' . htmlspecialchars($empruntsInfos3['card_emprunteur']); } ?>" class="btn btn-success">Emprunt</a><?php } ?>
                            </div>
                          </div>
                        </div>
                      </div>
                    </div>    
        <?php }} ?>
      </div>
      <div class="tab-pane fade <?php if($nbRetards == 0 AND $nbAujourdhui == 0 AND $nbEnCours == 0 AND $nbRetournes > 0){ echo 'show active'; } ?>" id="retournes" role="tabpanel" tabindex="0">
      <?php if($selectInfosFromEmprunts4->rowCount() > 0){
            while($empruntsInfos4 = $selectInfosFromEmprunts4->fetch()){

                $selectInfosFromBooksEmprunts4 = $bdd->prepare('SELECT * FROM books WHERE id = ?');
                $selectInfosFromBooksEmprunts4->execute(array($empruntsInfos4['id_book']));
                $recupBooks = $selectInfosFromBooksEmprunts4->fetch(); ?>   
                    <div class="container mt-3">
                      <div class="d-flex justify-content-center mt-4">
                        <div class="card text-center" style="width: 50rem;">
                          <div class="card-body">
                            <h5 class="card-title"><?= htmlspecialchars($recupBooks['titre']); ?></h5>
                            <h6 class="card-subtitle mb-2 text-body-secondary"><?= htmlspecialchars($recupBooks['auteur']); ?></h6>
                            <ul class="list-group list-group-flush">
                              <li class="list-group-item">Emprunté le <?php ConversionDateHour($empruntsInfos4['date_emprunt']); ?></li>
                              <li class="list-group-item">Retourné le <?php ConversionDateHour($empruntsInfos4['date_retour']); ?></li>
                            </ul>
                            <a href="books-reader.php?id=<?= htmlspecialchars($recupBooks['id']); ?>" class="btn btn-secondary">Voir</a>
                          </div>
                        </div>
                      </div>
                    </div>
        <?php }} ?>
      </div>
    </div>

<?php }else{die('Absence du n° de carte');} ?>
</div>
</body>
</html>