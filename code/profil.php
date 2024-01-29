
<?php require 'actions/database.php'; 
      require 'actions/users/securityAction.php';
      require 'actions/fonctions/transfoGradeIntVersText.php'; ?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <?php include 'includes/header.php' ?>
</head>
<body>
    <?php include 'includes/navbar.php'?>
    <br /><br />
    <?php if (isset($_GET['id'])) { ?>
    <?php
    $id = $_GET['id'];
    $selectInfosFromUsers= $bdd->prepare('SELECT * FROM users WHERE id = ?');
    $selectInfosFromUsers->execute(array($id));

    if($selectInfosFromUsers->rowCount() >= 1){

    $usersInfos = $selectInfosFromUsers->fetch();
?>
<div class="contour">
<div class="user-name"><h4><?= $usersInfos['prenom']; ?> <?= $usersInfos['nom']; ?></h4></div>
<hr />
<div class="user-infos">
    <p>
        ID : <?= $usersInfos['id']; ?><br />
        Numéro de carte : <?= $usersInfos['carte']; ?><br />
        Classe : <?= $usersInfos['classe']; ?><br />
        Date d'inscription : Le <?= $usersInfos['date']; ?> à <?= $usersInfos['heure']; ?><br />
        Grade : <?php Grade($usersInfos['grade']); ?>
    </p>
    <hr />
    <?php if ($usersInfos['id'] == $_SESSION['id']){ ?>
    <p>
            <a href="actions/users/logoutAction.php">Se déconnecter</a><br />
            <a href="">Modifier son compte</a>
    </p>
    <?php } ?>
</div>
</div>
<?php }else{ echo '<div class="msg msg-blue>"Aucun utilisateur avec l\'id n°' . $_GET["id"] . ' n\'a été trouvé.</div>'; }} ?>
</body>
</html>