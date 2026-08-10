<?php
//This file belongs to the BookFind project.
//
//BookFind is distributed under the terms of the MIT software license.
//
//Copyright (C) 2025 Chromared
?>



<?php require_once __DIR__ . '/../../../actions/functions/sessionInit.php';
$id = $_GET['id'] ?? null;
if (isset($_POST['validateMdp'])) {
    if ($_SESSION['grade'] == '1' or $_SESSION['grade'] == '2') {
        if (isset($_POST['new-password']) and isset($_POST['confirm-new-password'])) {
            if (!empty($_POST['new-password']) and !empty($_POST['confirm-new-password'])) {

                if ($_POST['new-password'] == $_POST['confirm-new-password']) {

                    $newPassword = password_hash($_POST['new-password'], PASSWORD_DEFAULT);
                    $id = $_GET['id'];

                    $updateMdp = $bdd->prepare('UPDATE users SET mdp = ? WHERE id = ?');
                    $updateMdp->execute(array($newPassword, $id));

                    // Récupérer informations utilisateur pour le log
                    $getUser = $bdd->prepare('SELECT id, prenom, nom FROM users WHERE id = ?');
                    $getUser->execute(array($id));
                    $usersInfos = $getUser->fetch();

                    SaveLog($bdd, $_SERVER['REQUEST_URI'], 'Modification de mot de passe', 'Le mot de passe de <a href="../profil.php?id=' . ($usersInfos['id'] ?? '') . '">' . htmlspecialchars($usersInfos['prenom'] ?? '') . ' ' . htmlspecialchars($usersInfos['nom'] ?? '') . '</a> à été changé.');

                    header('Location: update-user.php?id=' . $id . '&msg3=true');
                } else {
                    $errorMsg3 = 'Les deux nouveaux mot de passe ne sont pas identiques.';
                }
            } else {
                $errorMsg3 = 'Veuillez remplir tous les champs.';
            }
        } else {
            $errorMsg3 = 'Tous les champs n\'existent pas. Veuillez <a href="update-user.php?id=' . ($id ?? '') . '">recharger</a> la page.';
        }
    } else {
        $errorMsg3 = 'Vous n\'avez pas les droits pour effectuer cette action.';
    }
}
