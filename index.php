<?php
//This file belongs to the Bookfind project.
//
//Bookfind is distributed under the terms of the MIT software license.
//
//Copyright (C) 2025 Chromared
?>

<?php session_start(); ?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Accueil</title>
    <?php include 'includes/header.php'; ?>
</head>
<body>
  <?php include 'includes/navbar.php'; ?>
  <div class="container text-center mt-5">
    <img src="assets/iconesite.png" class="img-fluid w-25 display-4" />
    <h1 class="mt-3">Bienvenue sur BookFind !</h1>
  </div>
  <div class="container mt-3">
      <form method="GET" action="books.php">
          <div class="input-group mb-3">
            <input type="text" name="s" class="form-control" value="<?php if(isset($_GET['s']) AND !empty($_GET['s'])){echo htmlspecialchars($_GET['s']);} ?>" placeholder="Rechercher un livre" />
            <button class="btn btn-outline-secondary" type="submit" id="button-addon2">
              <i class="bi bi-search"></i>
              Rechercher
            </button>
          </div>
      </form>
  </div>
  <?php if(isset($_GET['signup']) and isset($_SESSION['auth'])){ ?>
    <div class="modal fade" id="successModal" tabindex="-1" aria-labelledby="successModalLabel" aria-hidden="true">
      <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title" id="successModalLabel">Inscription réussie</h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Fermer"></button>
          </div>
          <div class="modal-body">
            Votre compte a été créé avec succès. Pour vous connecter, vous aurez besoin de votre nom d'utilisateur qui est le suivant : <strong><?= htmlspecialchars($_SESSION['username']); ?></strong>.
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-success" data-bs-dismiss="modal">OK</button>
          </div>
        </div>
      </div>
    </div>
    <script>
        document.addEventListener("DOMContentLoaded", function() {
            var successModal = document.getElementById('successModal');
            var myModal = new bootstrap.Modal(successModal, {
                backdrop: 'static',
                keyboard: false
            });
            myModal.show();
        });
    </script>
  <?php } ?>
  <?php include 'includes/footer.php'; ?>
</body>
</html>