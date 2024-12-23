<?php
//This file belongs to the Bookfind project.
//
//Bookfind is distributed under the terms of the MIT software license.
//
//Copyright (C) 2024 Chromared
?>

<?php session_start();
    require 'actions/database.php'; ?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Configuration du projet</title>
    <?php include 'includes/header.php'; ?>
</head>
<body>
    <?php include 'includes/navbar.php'; ?>
        <h1>Bienvenue sur BookFind ! Ici, empruntez les livres du C.D.I !</h1><br />
        <h2>Bienvenue sur le fichier de configuration ! Ici, vous allez finir la configuration du site.</h2>
        <h3>Attention ! Il est important de suivre les étapes dans l'ordre. Certaines disparaîtrons au fur et à mesure, quand elles seront effectués.</h3><br />
                <?php if(empty($host) AND empty($dbname) AND empty($username)){ ?><p><strong>1. Configurer les accès à la base de donnée (cela fera disparaître l'erreur en haut de l'écran) :</strong> si vous ne l'avez as déjà fait, ouvrez le fichier database.php dans votre IDE ou dans le bloc-note Windows, par exemple, et remplissez vos informztions de connexions là ou il le faut. Sinon, servez-vous de ce formulaire : <br />
                <div id="db" class="update-part">    
                <form method="post">
                        <label for="host">Hôte :</label>
                        <input type="text" id="host" name="host" required /><br><br>

                        <label for="username">Nom d'utilisateur :</label>
                        <input type="text" id="username" name="username" required /><br><br>

                        <label for="password">Mot de Passe :</label>
                        <input type="password" id="password" name="password" /><br><br>

                        <input type="submit" value="Enregistrer" />
                </form>
                </div>
                                <?php if (isset($_POST['host']) AND isset($_POST['username']) AND isset($_POST['password']) AND !empty($_POST['host']) AND !empty($_POST['username'])) {
                                    $newHost = $_POST['host'];
                                    $newUsername = $_POST['username'];
                                    $newPassword = $_POST['password'];
                                
                                    $filePath = 'actions/database.php';
                                
                                    $fileContent = file_get_contents($filePath);
                                
                                    $fileContent = preg_replace("/\\\$host = '';/", "\$host = '$newHost';", $fileContent);
                                    $fileContent = preg_replace("/\\\$username = '';/", "\$username = '$newUsername';", $fileContent);
                                    $fileContent = preg_replace("/\\\$password = '';/", "\$password = '$newPassword';", $fileContent);
                                
                                    file_put_contents($filePath, $fileContent);
                                
                                    echo 'Fichier de configuration mis à jour avec succès. Rechargez la page <a href="configuration.php">ici</a>.';
                                }
                                ?>
                <?php }else{ echo 'Étape 1 validée.'; $step1 = true; } ?></p>

                <?php if (file_exists('actions/bookfind.sql')) { ?>
                <p><strong>2. Configurer la base de donnée :</strong> En cliquant sur ce bouton, la base de donnée va être importé sur le serveur : <form method="post"><input type="submit" name="import" value="Importer la base de donnée" /></form>
                
                <?php if(isset($_POST['import'])){
                    if(!empty($host) AND !empty($username)){
                    $sqlFile = 'actions/bookfind.sql';

                    $sql = file_get_contents($sqlFile);

                    if ($sql === false) {
                        die("Impossible de lire le fichier SQL.");
                    }

                    $createDatabase = $bdd->exec('CREATE DATABASE bookfind');

                    $filePath = 'actions/database.php';
                    $fileContent = file_get_contents($filePath);
                    $fileContent = preg_replace("/\\\$dbname = '';/", "\$dbname = 'bookfind';", $fileContent);
                    file_put_contents($filePath, $fileContent);

                    $queries = array_filter(array_map('trim', explode(';', $sql)));

                    foreach ($queries as $query) {
                        if (!empty($query)) {
                            if ($bdd->query($query) === false) {
                                echo 'Erreur lors de l\'exécution de la requête.';
                            }
                        }
                    }
                    unlink('actions/bookfind.sql');
                    echo 'Importation de la base de donnée terminée avec succès. Rechargez la page <a href="configuration.php">ici</a>.';
                }else{ echo 'Les identifiants de la base de donnée n\'ont pas été indiqués. Veuillez le faire à l\'aide du <a href="#db">formulaire</a> plus haut.'; }}
            }else{ echo 'Étape 2 validée.'; $step2 = true; } ?>
                    <br /></p>

                <p><strong>3. Création des classes :</strong> lors de l'inscription d'un utilisateur, sa classe lui est demandée (Ex : 6B, 5A...). Dans ce formulaire, vous allez pouvoir créer autant de classe que vous voulez. Attention : la classe sert juste à caractériser un utilisateur. Elle n'influe pas sur le grade et ne donne pas de permissions. Voici le formulaire :<br />
            
                <div class="update-part">
                <form method="post">                                
                                <label for="classe">Classe : </label>
                                <input type="text" id="classe" name="classe" required />
                                <input type="submit" name="validate" value="Ajouter cette classe" required />
                </form>
                </div>

                <?php if(isset($_POST['validate']) AND isset($_POST['classe']) AND !empty($_POST['classe'])){
                    if(!empty($host) AND !empty($dbname) AND !empty($username)){
                    $classe = $_POST['classe'];

                    $checkIfClasseAlreadyExists = $bdd->prepare('SELECT name FROM classes WHERE name = ?');
                    $checkIfClasseAlreadyExists->execute(array($classe));

                    if($checkIfClasseAlreadyExists->rowCount() == 0){

                        $addClasse = $bdd->prepare('INSERT INTO classes SET name = ?');
                        $addClasse->execute(array($classe));

                        echo 'Classe ajoutée avec succès.<br />';

                    }else{ echo 'Cette classe existe déjà. <br />'; }
                    
                }else{ echo 'Les identifiants de la base de donnée n\'ont pas été indiqués. Veuillez le faire à l\'aide du <a href="#db">formulaire</a> plus haut.'; }
            } if(!empty($host) AND !empty($dbname) AND !empty($username)){
            $checkIfTwoClassesExists = $bdd->query('SELECT name FROM classes');
            if($checkIfTwoClassesExists->rowCount() >= 2){ echo 'Étape 3 validée. Vous pouvez toujours continuer d\'ajouter des classes.'; $step3 = true; }} ?>
            </p>
                <?php if(!empty($host) AND !empty($dbname) AND !empty($username)){
                    $checkIfOneUserExist = $bdd->query('SELECT id FROM users');
                                    if($checkIfOneUserExist->rowCount() == 0){ ?>

                <p><strong>4. Création d'un compte administrateur :</strong> vous pouvez créer le premier compte, qui sera automatiquement gradé en tant que "administrateur". Pour cela, rendez-vous sur la page d'<a href="signup.php" target="_blank">inscription</a> pour vous inscrire.</p>
            <?php }else{ echo 'Étape 4 validée.'; $step4 = true; }} ?>

            <?php if(isset($step1) AND isset($step2) AND isset($step3) AND isset( $step4)){
                if($step1 === true AND $step2 === true AND $step3 === true AND $step4 === true){ ?>

                <h4>Vous avez validé toutes les étapes ! Pour des raisons de sécurité, veuillez détruire ce fichier en cliquant sur ce bouton :</h4>
                <form method="post">
                    <input type="submit" name="delete" value="Supprimer ce fichier" />
                </form>

            <?php  if(isset($_POST['delete'])){ 
                unlink('configuration.php');
                echo 'Page supprimée. Vous pouvez fermer la page ou vous rendre à l\'accueil en cliquant <a href="index.php">ici</a>.';
             }}} ?>
</body>
</html>