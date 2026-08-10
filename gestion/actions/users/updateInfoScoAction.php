<?php
//This file belongs to the BookFind project.
//
//BookFind is distributed under the terms of the MIT software license.
//
//Copyright (C) 2025 Chromared
?>



<?php require_once __DIR__ . '/../../../actions/functions/sessionInit.php';
$id = $_GET['id'] ?? null;
if (isset($_POST['validateInfoSco'])) {
    if ($_SESSION['grade'] == '1' or $_SESSION['grade'] == '2') {
        if (isset($_POST['classe'])) {
            if (!empty(!empty($_POST['classe']))) {

                $classe = $_POST['classe'];
                $id = $_GET['id'];

                $checkIfClasseAlreadyExists = $bdd->prepare('SELECT name FROM classes WHERE name = ?');
                $checkIfClasseAlreadyExists->execute(array($classe));

                if ($checkIfClasseAlreadyExists->rowCount() > 0) {

                    header('Location: update-user.php?id=' . $id . '&msg2=true');
                        $updateInfoSco = $bdd->prepare('UPDATE users SET classe = ? WHERE id = ?');
                        $updateInfoSco->execute(array($classe, $id));

                        // Récupérer infos avant changement
                        $getUser = $bdd->prepare('SELECT id, prenom, nom, classe FROM users WHERE id = ?');
                        $getUser->execute(array($id));
                        $usersInfos = $getUser->fetch();

                        if ($classe != ($usersInfos['classe'] ?? '')) {
                            SaveLog($bdd, $_SERVER['REQUEST_URI'], 'Modification de compte', 'La classe de <a href="../profil.php?id=' . ($usersInfos['id'] ?? '') . '">' . htmlspecialchars($usersInfos['prenom'] ?? '') . ' ' . htmlspecialchars($usersInfos['nom'] ?? '') . '</a> a été modifié passant de ' . htmlspecialchars($usersInfos['classe'] ?? '') . ' à ' . htmlspecialchars($classe) . '.');
                        }

                        header('Location: update-user.php?id=' . $id . '&msg2=true');
                } else {
                    $errorMsg2 = 'La classe sélectionnée n\'existe pas.';
                }
            } else {
                $errorMsg2 = 'Tous les champs doivent être remplis.';
            }
        } else {
            $errorMsg2 = 'Tous les champs n\'existent pas. Recharger la page <a href="update-user.php?id=' . ($id ?? '') . '">ici</a>.';
        }
    } else {
        $errorMsg2 = 'Vous n\'avez pas les droits pour effectuer cette action.';
    }
}
