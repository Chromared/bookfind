<?php
//This file belongs to the BookFind project.
//
//BookFind is distributed under the terms of the MIT software license.
//
//Copyright (C) 2025 Chromared
?>



<?php
    $selectUsers = $bdd->prepare('SELECT * FROM users');
    $selectUsers->execute();
    while($user = $selectUsers->fetch()){
      echo '<option value="' . $user['id'] . '">' . htmlspecialchars($user['prenom'] . ' ' . $user['nom']) . ' (' . $user['classe'] . ')</option>';
    }
?>