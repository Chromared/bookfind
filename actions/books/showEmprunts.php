<?php
//This file belongs to the Bookfind project.
//
//Bookfind is distributed under the terms of the MIT software license.
//
//Copyright (C) 2025 Chromared
?>


<?php if (isset($_GET['card']) AND !empty($_GET['card'])){
    $card = htmlspecialchars($_GET['card']); 
    $Now = date("Y-m-d");

    if($card == $_SESSION['card'] OR $_SESSION['grade'] !== 0){

      $selectInfosFromEmprunts1 = $bdd->prepare('SELECT * FROM emprunts WHERE card_emprunteur = ? AND statut = 1 AND date_futur_retour < ? ORDER BY date_futur_retour');
      $selectInfosFromEmprunts1->execute(array($card, $Now));

      $selectInfosFromEmprunts2 = $bdd->prepare('SELECT * FROM emprunts WHERE card_emprunteur = ? AND statut = 1 AND date_futur_retour = ? ORDER BY date_futur_retour');
      $selectInfosFromEmprunts2->execute(array($card, $Now));

      $selectInfosFromEmprunts3 = $bdd->prepare('SELECT * FROM emprunts WHERE card_emprunteur = ? AND statut = 1 AND date_futur_retour > ? ORDER BY date_futur_retour');
      $selectInfosFromEmprunts3->execute(array($card, $Now));

      $selectInfosFromEmprunts4 = $bdd->prepare('SELECT * FROM emprunts WHERE card_emprunteur = ? AND statut = 2 ORDER BY date_retour DESC');
      $selectInfosFromEmprunts4->execute(array($card));

      if($card !== $_SESSION['card']){

        SaveLog($bdd, $_SERVER['REQUEST_URI'], 'Consultation des emprunts', 'Aucun commentaire'/*'Le profil de <a href="../profil.php?id=' . htmlspecialchars($usersInfos['id']) . '">' . htmlspecialchars($usersInfos['prenom']) . ' ' . htmlspecialchars($usersInfos['nom']) . '</a> a été consulté.'*/);

      }
    
    }
}
