<?php
//This file belongs to the Bookfind project.
//
//Bookfind is distributed under the terms of the MIT software license.
//
//Copyright (C) 2025 Chromared
?>



<?php
    $selectUsers = $bdd->prepare('SELECT * FROM users');
    $selectUsers->execute();
    while($user = $selectUsers->fetch()){
      echo '<option value="' . $user['id'] . '">' . htmlspecialchars($user['prenom'] . ' ' . $user['nom']) . ' (' . $user['username'] . ')</option>';
    }
?>