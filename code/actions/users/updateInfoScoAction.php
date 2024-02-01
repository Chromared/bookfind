<?php if (isset($_POST['validateInfoSco'])) {
    if (isset($_POST['card']) AND isset($_POST['classe'])){
    if (!empty($_POST['card']) AND !empty($_POST['classe'])){
        $card = htmlspecialchars($_POST['card']);
        $classe = htmlspecialchars($_POST['classe']);
        $id = $_SESSION['id'];

        $updateInfoSco = $bdd->prepare('UPDATE users SET carte = ?, classe = ? WHERE id = ?');
        $updateInfoSco->execute(array($card, $classe, $id));

        header('Location: updateProfil.php?id=' . $id .'');
    }else{
        $errorMsg = 'Veuillez compléter tous les champs';
    }
}
}