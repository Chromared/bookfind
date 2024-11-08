# This file belongs to the Bookfind project.
#
# Bookfind is distributed under the terms of the MIT software license.
#
# Copyright (C) 2024 Chromared


<?php $id = htmlspecialchars($_GET['id']);
      $selectInfosFromUsers= $bdd->prepare('SELECT * FROM users WHERE id = ?');
      $selectInfosFromUsers->execute(array($id));

      $usersInfos = $selectInfosFromUsers->fetch();