# X11 License
# 2024 Chromared


<?php $card = htmlspecialchars($_GET['card']);
      $selectInfosFromEmprunts= $bdd->prepare('SELECT * FROM emprunts WHERE card_emprunteur = ? ORDER BY date_retour');
      $selectInfosFromEmprunts->execute(array($card));