# X11 License
# 2024 Chromared


<?php if (isset($_POST['validateDelete2'])){
    if(isset($_POST['confirm-delete'])){
    if(!empty($_POST['confirm-delete'])){

        $checkPassword = $bdd->prepare('DELETE * FROM users WHERE id = ?');
        $checkPassword->execute(array($id));

        header('Location: actions/users/logoutAction.php');
}
}
}