<?php
//This file belongs to the Bookfind project.
//
//Bookfind is distributed under the terms of the MIT software license.
//
//Copyright (C) 2025 Chromared
?>


<?php if (isset($_GET['id']) AND !empty($_GET['id'])){
    $id = htmlspecialchars($_GET['id']); 
    $Now = date("Y-m-d");

    if($id == $_SESSION['id'] OR $_SESSION['grade'] !== 0){

      $selectInfosFromEmprunts1 = $bdd->prepare('SELECT * FROM emprunts WHERE id_emprunteur = ? AND statut = 1 AND date_futur_retour < ? ORDER BY date_futur_retour');
      $selectInfosFromEmprunts1->execute(array($id, $Now));

      $selectInfosFromEmprunts2 = $bdd->prepare('SELECT * FROM emprunts WHERE id_emprunteur = ? AND statut = 1 AND date_futur_retour = ? ORDER BY date_futur_retour');
      $selectInfosFromEmprunts2->execute(array($id, $Now));

      $selectInfosFromEmprunts3 = $bdd->prepare('SELECT * FROM emprunts WHERE id_emprunteur = ? AND statut = 1 AND date_futur_retour > ? ORDER BY date_futur_retour');
      $selectInfosFromEmprunts3->execute(array($id, $Now));

      $selectInfosFromEmprunts4 = $bdd->prepare('SELECT * FROM emprunts WHERE id_emprunteur = ? AND statut = 2 ORDER BY date_retour DESC');
      $selectInfosFromEmprunts4->execute(array($id));

      if($id != $_SESSION['id']){

        SaveLog($bdd, $_SERVER['REQUEST_URI'], 'Consultation des emprunts', 'Aucun commentaire');

      }
    
    }
}
