<?php if(isset($_POST['validateTheme'])){
    $id = $_SESSION['id'];
    $theme = htmlspecialchars($_POST['theme']);

    if($theme == '0' OR $theme == '1'){

        $updateTheme = $bdd->prepare('UPDATE users SET theme = ? WHERE id = ?');
        $updateTheme->execute(array($theme, $id));

        $_SESSION['theme'] = $theme;

        header('Location: settings.php?id=' . $id . '&msg1=success');
    }else{
        $errorMsg1 = 'Veuillez sélectionner un thème valide.';
    }
}