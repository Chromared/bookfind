<?php
//This file belongs to the BookFind project.
//
//BookFind is distributed under the terms of the GNU Affero General Public License v3.0.
//
//Copyright (C) 2025 Chromared
?>



<?php require_once __DIR__ . '/../../../actions/functions/sessionInit.php';
  $selectUsers = $db->prepare('SELECT * FROM users');
    $selectUsers->execute();
    while($user = $selectUsers->fetch()){
      echo '<option value="' . $user['id'] . '">' . htmlspecialchars($user['first_name'] . ' ' . $user['last_name']) . ' (' . $user['class_name'] . ')</option>';
    }
?>