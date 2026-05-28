<?php if (isset($_POST["regenUsernames"])) {
    $selectNames = $bdd->query('SELECT id, nom, prenom FROM users');
    $i = 0;

    while ($userInfos = $selectNames->fetch()) {

        $newUsername = username($userInfos['prenom'], $userInfos['nom']);
        $updateUsername = $bdd->prepare('UPDATE users SET username = ? WHERE id = ?');
        $updateUsername->execute(array($newUsername, $userInfos['id']));

        $i += 1;
    }

    $msgRegenUsernames = 'Le nom d\'utilisateur de ' . $i . ' utilisateurs a été régénéré.';
}
