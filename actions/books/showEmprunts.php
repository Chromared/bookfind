<?php $card = htmlspecialchars($_GET['card']);
      $selectInfosFromEmprunts= $bdd->prepare('SELECT * FROM emprunts WHERE card_emprunteur = ?');
      $selectInfosFromEmprunts->execute(array($card));

      $empruntsInfos = $selectInfosFromEmprunts->fetch();

      //$selectInfosFromBooksEmprunts= $bdd->prepare('SELECT * FROM books WHERE  = ?');
      //$selectInfosFromBooksEmprunts->execute(array($));