# X11 License
# Copyright © 2024 Chromared


<?php if(isset($_POST['validateAuthor'])){
    if(isset($_POST['firstname']) AND isset($_POST['name'])){
    if(!empty($_POST['firstname']) AND !empty($_POST['name']))

        $firstname = $_POST['firstname'];
        $name = $_POST['name'];

        if(isset($_POST['bio']) AND !empty($_POST['bio'])){
            $bio = $_POST['bio'];
        }else{$bio = false;}

        $addAuthor = $bdd->prepare('INSERT INTO authors SET prenom = ?, nom = ?, biographie = ?');
        $addAuthor->execute(array($firstname, $name, $bio));

        header('Location: add-books.php');

    }
}