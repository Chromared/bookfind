<?php if(isset($_POST['validate'])){
    if(isset($_POST['id']) AND !empty($_POST['id'])){

        //Pour le statut, 1 = emprunté, 2 = retourné. NULL ou autre = erreur -> à corriger
        $updateEmpruntForBooks = $bdd->prepare('UPDATE books SET statut = ? WHERE id = ?');
        $updateEmpruntForBooks->execute(array(2, $book));

    }
}