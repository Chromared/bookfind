<?php
//This file belongs to the Bookfind project.
//
//Bookfind is distributed under the terms of the MIT software license.
//
//Copyright (C) 2025 Chromared
?>



<?php if(isset($_POST['classeAddValidate'])){
    $newClasse = $_POST['newClasse'];

    $checkIfClasseAlreadyExists = $bdd->prepare('SELECT name FROM classes WHERE name = ?');
    $checkIfClasseAlreadyExists->execute(array($newClasse));

    if($checkIfClasseAlreadyExists->rowCount() == 0){

    $addClasse = $bdd->prepare('INSERT INTO classes SET name = ?');
    $addClasse->execute(array($newClasse));

    SaveLog($bdd, $_SERVER['REQUEST_URI'], 'Ajout d\'une classe', 'La classe "' . htmlspecialchars($newClasse) . '" à été ajoutée.');

    header('Location: bookfind.php');

    }else{ $msgC1 = 'Cette classe existe déjà.'; }
}