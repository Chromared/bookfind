<?php
// This file belongs to the Bookfind project. Distributed under MIT license.
session_start();
require 'actions/database.php';
?>
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

    <div class="container my-5">
        <h1 class="text-center mb-3">Bienvenue sur BookFind !</h1>
        <h2 class="text-center mb-3">Fichier de configuration du site</h2>
        <div class="alert alert-warning text-center" role="alert">
            <i class="bi bi-exclamation-triangle-fill me-2"></i>
            Suivez bien les étapes dans l'ordre. Certaines disparaîtront quand elles seront terminées.
        </div>

        <!-- Etape 1 : Accès à la base de données -->
        <?php if (empty($host) && empty($dbname) && empty($username)) { ?>
        <div class="card mb-4">
            <div class="card-header">
                1. Configurer les accès MySQL
            </div>
            <div class="card-body">
                <form method="post">
                    <div class="mb-3">
                        <label for="host" class="form-label">Hôte</label>
                        <input type="text" class="form-control" id="host" name="host" required>
                    </div>
                    <div class="mb-3">
                        <label for="username" class="form-label">Nom d'utilisateur</label>
                        <input type="text" class="form-control" id="username" name="username" required>
                    </div>
                    <div class="mb-3">
                        <label for="password" class="form-label">Mot de passe</label>
                        <input type="password" class="form-control" id="password" name="password">
                    </div>
                    <button type="submit" class="btn btn-primary w-100">
                        <i class="bi bi-save me-2"></i>Enregistrer
                    </button>
                </form>
                <?php
                if (isset($_POST['host'], $_POST['username'], $_POST['password']) && !empty($_POST['host']) && !empty($_POST['username'])) {
                    $host = $_POST['host'];
                    $username = $_POST['username'];
                    $password = $_POST['password'];
                    $filePath = 'actions/database.php';
                    $fileContent = file_get_contents($filePath);
                    $fileContent = preg_replace("/\\\$host = '';/", "\$host = '$host';", $fileContent);
                    $fileContent = preg_replace("/\\\$username = '';/", "\$username = '$username';", $fileContent);
                    $fileContent = preg_replace("/\\\$password = '';/", "\$password = '$password';", $fileContent);
                    file_put_contents($filePath, $fileContent);
                    echo '<div class="alert alert-success mt-3">Enregistré avec succès ! <a href="configuration.php">Recharger la page</a>.</div>';
                }
                ?>
            </div>
        </div>
        <?php } else { echo '<div class="alert alert-success">Étape 1 validée.</div>'; $step1 = true; } ?>

        <!-- Etape 2 : Importer la base de données -->
        <?php if (file_exists('actions/bookfind.sql')) { ?>
        <div class="card mb-4">
            <div class="card-header">
                2. Importer la base de données
            </div>
            <div class="card-body">
                <form method="post" class="mb-3">
                    <button type="submit" name="import" class="btn btn-primary w-100">
                        <i class="bi bi-database me-2"></i>Importer la base de données
                    </button>
                </form>
                <form method="post">
                    <div class="input-group">
                        <input type="text" name="dbname" class="form-control" placeholder="Nom de la base de données" required>
                        <button type="submit" name="alreadyImport" class="btn btn-secondary">
                            J'ai déjà importé la base de données
                        </button>
                    </div>
                </form>
                <?php
                if (isset($_POST['dbname'], $_POST['alreadyImport']) && !empty($_POST['dbname'])) {
                    if (!empty($host) && !empty($username)) {
                        $dbname = $_POST['dbname'];
                        $filePath = 'actions/database.php';
                        $fileContent = file_get_contents($filePath);
                        $fileContent = preg_replace("/\\\$dbname = '';/", "\$dbname = '$dbname';", $fileContent);
                        file_put_contents($filePath, $fileContent);
                        unlink('actions/bookfind.sql');
                        echo '<div class="alert alert-success mt-3">Enregistré avec succès ! <a href="configuration.php">Recharger la page</a>.</div>';
                    } else {
                        echo '<div class="alert alert-danger mt-3">Identifiants MySQL manquants. Remplissez d\'abord le formulaire plus haut.</div>';
                    }
                }

                if (isset($_POST['import'])) {
                    if (!empty($host) && !empty($username)) {
                        $filePath = 'actions/database.php';
                        $fileContent = file_get_contents($filePath);
                        $fileContent = preg_replace("/\\\$dbname = '';/", "\$dbname = 'bookfind';", $fileContent);
                        file_put_contents($filePath, $fileContent);
                        $sqlFilePath = 'actions/bookfind.sql';
                        $sql = file_get_contents($sqlFilePath);
                        $bdd->exec('CREATE DATABASE bookfind');
                        $queries = array_filter(array_map('trim', explode(';', $sql)));
                        foreach ($queries as $query) {
                            if (!empty($query)) {
                                if ($bdd->query($query) === false) {
                                    echo '<div class="alert alert-danger">Erreur d\'exécution SQL.</div>';
                                }
                            }
                        }
                        unlink('actions/bookfind.sql');
                        echo '<div class="alert alert-success mt-3">Base de données importée. <a href="configuration.php">Recharger la page</a>.</div>';
                    } else {
                        echo '<div class="alert alert-danger mt-3">Identifiants MySQL manquants. Remplissez d\'abord le formulaire plus haut.</div>';
                    }
                }
                ?>
            </div>
        </div>
        <?php } else { echo '<div class="alert alert-success">Étape 2 validée.</div>'; $step2 = true; } ?>

        <!-- Etape 3 : Ajout des classes -->
        <div class="card mb-4">
            <div class="card-header">
                3. Créer des classes
            </div>
            <div class="card-body">
                <form method="post" class="mb-3">
                    <div class="input-group">
                        <input type="text" list="classes" id="classe" name="classe" class="form-control" placeholder="Ex : 6B" required>
                        <button type="submit" name="validate" class="btn btn-primary">Ajouter</button>
                    </div>
                    <datalist id="classes">
                        <?php echo '<option value="' . htmlspecialchars($_POST['classe'] ?? '') . '">' . htmlspecialchars($_POST['classe'] ?? '') . '</option>'; ?>
                        <?php include 'actions/functions/recupClassesAndOptions.php'; ?>
                    </datalist>
                </form>
                <?php
                if (isset($_POST['validate'], $_POST['classe']) && !empty($_POST['classe'])) {
                    if (!empty($host) && !empty($dbname) && !empty($username)) {
                        $classe = $_POST['classe'];
                        $checkIfClasseAlreadyExists = $bdd->prepare('SELECT name FROM classes WHERE name = ?');
                        $checkIfClasseAlreadyExists->execute([$classe]);
                        if ($checkIfClasseAlreadyExists->rowCount() == 0) {
                            $addClasse = $bdd->prepare('INSERT INTO classes SET name = ?');
                            $addClasse->execute([$classe]);
                            echo '<div class="alert alert-success mt-3">Classe ajoutée avec succès.</div>';
                        } else {
                            echo '<div class="alert alert-warning mt-3">Cette classe existe déjà.</div>';
                        }
                    } else {
                        echo '<div class="alert alert-danger mt-3">Identifiants MySQL manquants. Remplissez d\'abord le formulaire plus haut.</div>';
                    }
                }

                if (!empty($host) && !empty($dbname) && !empty($username)) {
                    $checkIfTwoClassesExists = $bdd->query('SELECT name FROM classes');
                    if ($checkIfTwoClassesExists->rowCount() >= 2) {
                        echo '<div class="alert alert-success">Étape 3 validée.</div>';
                        $step3 = true;
                    }
                }
                ?>
            </div>
        </div>

        <!-- Etape 4 : Compte administrateur -->
        <?php $checkIfOneUserExist = $bdd->query('SELECT id FROM users');
        if ($checkIfOneUserExist->rowCount() == 0) { ?>
        <div class="alert alert-info">
            4. Créez le premier compte administrateur en vous inscrivant via la <a href="signup.php">page d'inscription</a>.
        </div>
        <?php } else { echo '<div class="alert alert-success">Étape 4 validée.</div>'; $step4 = true; } ?>

        <!-- Suppression du fichier de configuration -->
        <?php if (isset($step1, $step2, $step3, $step4) && $step1 && $step2 && $step3 && $step4) { ?>
        <div class="card mt-5">
            <div class="card-body text-center">
                <h4>Félicitations ! Configuration terminée.</h4>
                <p>Pour des raisons de sécurité, veuillez supprimer ce fichier.</p>
                <form method="post">
                    <button type="submit" name="delete" class="btn btn-danger">
                        <i class="bi bi-trash me-2"></i>Supprimer ce fichier
                    </button>
                </form>
            </div>
        </div>
        <?php if (isset($_POST['delete'])) {
            unlink('configuration.php');
            echo '<div class="alert alert-success mt-3">Fichier supprimé avec succès. Vous pouvez maintenant accéder au <a href="index.php">site</a>.</div>';
        } } ?>
    </div>
</body>
</html>