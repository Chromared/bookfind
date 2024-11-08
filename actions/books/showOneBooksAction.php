# X11 License
# 2024 Chromared


<?php $id = htmlspecialchars($_GET['id']);
      $selectInfosFromBooks= $bdd->prepare('SELECT * FROM books WHERE id = ?');
      $selectInfosFromBooks->execute(array($id));

      $booksInfos = $selectInfosFromBooks->fetch();