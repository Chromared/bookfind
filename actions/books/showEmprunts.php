# This file belongs to the Bookfind project.
#
# Bookfind is distributed under the terms of the MIT software license.
#
# Copyright (C) 2024 Chromared

<?php $card = htmlspecialchars($_GET['card']);
      $selectInfosFromEmprunts= $bdd->prepare('SELECT * FROM emprunts WHERE card_emprunteur = ? ORDER BY date_retour');
      $selectInfosFromEmprunts->execute(array($card));