# X11 License
# 2024 Chromared


<?php if (isset($_POST['validateDelete2'])){
    if(isset($_POST['confirm-delete'])){
    if(!empty($_POST['confirm-delete'])){

        $id = $_GET['id'];

        $DeleteUserAccount = $bdd->prepare('DELETE FROM users WHERE id = ?');
        $DeleteUserAccount->execute(array($id));

        header('Location: users.php');
        
        
}
}
}