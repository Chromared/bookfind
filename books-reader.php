<?php session_start();
    require 'actions/database.php';
    require 'actions/books/showOneBooksAction.php'; ?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <?php include 'includes/header.php'; ?>
</head>
<body>
    <?php include 'includes/navbar.php'; ?>
<div class="contour">
<div class="reader-part">
<div class="book-name"><h4><?= htmlspecialchars($booksInfos['titre']); ?></h4></div>
<div class="books-infos">
    <p>
        ID : <?= htmlspecialchars($booksInfos['id']); ?><br />
        Auteur : <?= htmlspecialchars($booksInfos['auteur']); ?><br />
        Résumé : <?php if(!empty($booksInfos['resume'])){ echo $booksInfos['resume']; }else{ echo 'Il n\'y a pas de résumé pour ce livre.'; } ?><br />
        Identifiant unique : <?php if(!empty($booksInfos['id_unique'])){ echo $booksInfos['id_unique']; }else{ echo 'Il n\'y a pas d\'identifiant unique pour ce livre.'; } ?><br />
        ISBN : <?= htmlspecialchars($booksInfos['isbn']); ?><br />
        Éditeur : <?= htmlspecialchars($booksInfos['editeur']); ?><br />
        Type : <?= htmlspecialchars($booksInfos['type']); ?><br />
        Genre : <?php if(!empty($booksInfos['genre'])){ echo $booksInfos['genre']; }else{ echo 'Il n\'y a pas de genre pour ce livre.'; } ?><br />
        <?php if(!empty($booksInfos['serie'])){ echo 'Tome ' . $booksInfos['tome'] . ' de la série ' . $booksInfos['serie'] . '.'; } ?><br />
    </p>
</div></div>
</div>
</body>
</html>