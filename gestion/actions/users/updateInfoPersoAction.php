<?php
//This file belongs to the BookFind project.
//
//BookFind is distributed under the terms of the MIT software license.
//
//Copyright (C) 2025 Chromared
?>



<?php require_once __DIR__ . '/../../../actions/functions/sessionInit.php';
$id = $_GET['id'] ?? null;
if (isset($_POST['validateInfoPerso'])) {
    if ($_SESSION['grade'] == '1' or $_SESSION['grade'] == '2') {
        if (isset($_POST['name']) and isset($_POST['firstname'])) {
            if (!empty($_POST['name']) and !empty($_POST['firstname'])) {
                $name = $_POST['name'];
                $firstname = $_POST['firstname'];
                $id = $_GET['id'];

                $updateInfoPerso = $bdd->prepare('UPDATE users SET nom = ?, prenom = ? WHERE id = ?');
                $updateInfoPerso->execute(array($name, $firstname, $id));

                // Récupérer informations utilisateur avant le changement pour le log
                $getUser = $bdd->prepare('SELECT id, prenom, nom FROM users WHERE id = ?');
                $getUser->execute(array($id));
                $usersInfos = $getUser->fetch();

                if ($name != ($usersInfos['nom'] ?? '') and $firstname == ($usersInfos['prenom'] ?? '')) {
                    SaveLog($bdd, $_SERVER['REQUEST_URI'], 'Modification de compte', 'Modification du nom de famille de <a href="../profil.php?id=' . ($usersInfos['id'] ?? '') . '">' . htmlspecialchars($usersInfos['prenom'] ?? '') . ' ' . htmlspecialchars($usersInfos['nom'] ?? '') . '</a> passant de ' . htmlspecialchars($usersInfos['nom'] ?? '') . ' à ' . htmlspecialchars($name) . '.');
                } elseif ($name == ($usersInfos['nom'] ?? '') and $firstname != ($usersInfos['prenom'] ?? '')) {
                    SaveLog($bdd, $_SERVER['REQUEST_URI'], 'Modification de compte', 'Modification du nom de prénom de <a href="../profil.php?id=' . ($usersInfos['id'] ?? '') . '">' . htmlspecialchars($usersInfos['prenom'] ?? '') . ' ' . htmlspecialchars($usersInfos['nom'] ?? '') . '</a> passant de ' . htmlspecialchars($usersInfos['prenom'] ?? '') . ' à ' . htmlspecialchars($firstname) . '.');
                } elseif ($name != ($usersInfos['nom'] ?? '') and $firstname != ($usersInfos['prenom'] ?? '')) {
                    SaveLog($bdd, $_SERVER['REQUEST_URI'], 'Modification de compte', 'Modification du prénom et du nom de famille de <a href="../profil.php?id=' . ($usersInfos['id'] ?? '') . '">' . htmlspecialchars($usersInfos['prenom'] ?? '') . ' ' . htmlspecialchars($usersInfos['nom'] ?? '') . '</a>. Son ancien prénom était ' . htmlspecialchars($usersInfos['prenom'] ?? '') . ' et est maintenant ' . htmlspecialchars($firstname) . '. Quant à son nom, il passe de ' . htmlspecialchars($usersInfos['nom'] ?? '') . ' à ' . htmlspecialchars($name) . '.');
                }

                header('Location: update-user.php?id=' . $id . '&msg1=true');
            } else {
                $errorMsg1 = 'Veuillez remplir tous les champs.';
            }
        } else {
            $errorMsg1 = 'Tous les champs n\'existent pas. Veuillez <a href="update-user.php?id=' . ($id ?? '') . '">recharger</a> la page.';
        }
    } else {
        $errorMsg1 = 'Vous n\'avez pas les droits pour effectuer cette action.';
    }
}
