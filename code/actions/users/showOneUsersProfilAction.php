<?php $id = $_GET['id'];
      $selectInfosFromUsers= $bdd->prepare('SELECT * FROM users WHERE id = ?');
      $selectInfosFromUsers->execute(array($id));

      $usersInfos = $selectInfosFromUsers->fetch();