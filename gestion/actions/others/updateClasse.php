<?php
//This file belongs to the Bookfind project.
//
//Bookfind is distributed under the terms of the MIT software license.
//
//Copyright (C) 2025 Chromared
?>



<?php if(isset($_POST['classeUpdateValidate'])){
    $existingClasse = $_POST['existingClasse'];
    $newClasse = $_POST['newClasseName'];

    $checkIfClasseAlreadyExists = $bdd->prepare('SELECT name FROM classes WHERE name = ?');
    $checkIfClasseAlreadyExists->execute(array($existingClasse));

    if($checkIfClasseAlreadyExists->rowCount() != 0){

    $addClasse = $bdd->prepare('UPDATE classes SET name = ? WHERE name = ?');
    $addClasse->execute(array($newClasse, $existingClasse));

    $updateClasseForUsers = $bdd->prepare('UPDATE users SET classe = ? WHERE classe = ?');
    $updateClasseForUsers->execute(array($newClasse, $existingClasse));

    SaveLog($bdd, $_SERVER['REQUEST_URI'], 'Modification d\'une classe', 'La classe "' . htmlspecialchars($newClasse) . '" à été renommé en ' . $newClasse . '.');

    header('Location: bookfind.php');

    }else{ $msgC2 = 'La classe que vous souhaitez modifier n\'existe pas.'; }
}