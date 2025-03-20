<?php if(isset($_POST['classeDeleteValidate'])){
    $existingClasse = $_POST['existingClasse2'];

    $checkIfClasseAlreadyExists = $bdd->prepare('SELECT name FROM classes WHERE name = ?');
    $checkIfClasseAlreadyExists->execute(array($existingClasse));

    if($checkIfClasseAlreadyExists->rowCount() > 0){

    $addClasse = $bdd->prepare('DELETE FROM classes WHERE name = ?');
    $addClasse->execute(array($existingClasse));

    $updateClasseForUsers = $bdd->prepare('UPDATE users SET classe = ? WHERE classe = ?');
    $updateClasseForUsers->execute(array('Aucune', $existingClasse));

    SaveLog($bdd, $_SERVER['REQUEST_URI'], 'Suppression d\'une classe', 'La classe "' . htmlspecialchars($existingClasse) . '" à été supprimé. Les utilisateurs de cette classe ont été déplacé dans la classe "Aucune".');

    header('Location: bookfind.php');

    }else{ $msgC3 = 'Cette classe existe déjà.'; }
}