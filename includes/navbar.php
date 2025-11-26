<?php
//This file belongs to the Bookfind project.
//
//Bookfind is distributed under the terms of the MIT software license.
//
//Copyright (C) 2025 Chromared
?>



<?php $pageActuelle = basename($_SERVER['SCRIPT_NAME']); ?>
<nav class="navbar fixed-top navbar-expand-lg bg-primary" data-bs-theme="dark">
  <div class="container-fluid">
  <a class="navbar-brand" href="index.php">
      <img src="assets/iconesite.png" alt="BookFind logo" width="40" height="30" class="d-inline-block align-text-top img-fluid">
      BookFind
    </a>
    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarScroll" aria-controls="navbarScroll" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarScroll">
      <ul class="navbar-nav me-auto my-2 my-lg-0 navbar-nav-scroll" style="--bs-scroll-height: 100px;">
        <li class="nav-item">
          <a class="nav-link <?php if($pageActuelle == 'index.php'){ echo 'active'; } ?>" aria-current="page" href="index.php">Accueil</a>
        </li>
        <?php if(file_exists('configuration.php')) { ?>
            <li class="nav-item">
              <a class="nav-link <?php if($pageActuelle == 'configuration.php'){ echo 'active'; } ?>" href="configuration.php">Configurer BookFind</a>
            </li>
        <?php } ?>
        <?php if(!isset($_SESSION['auth'])){ ?>
            <li class="nav-item">
              <a class="nav-link <?php if($pageActuelle == 'login.php'){ echo 'active'; } ?>" href="login.php">Se connecter</a>
            </li>
            <?php // Afficher "S'inscrire" uniquement si l'action d'inscription est disponible ?>
            <?php if (file_exists('actions/users/signupAction.php') && file_exists('signup.php')) { ?>
            <li class="nav-item">
              <a class="nav-link <?php if($pageActuelle == 'signup.php'){ echo 'active'; } ?>" href="signup.php">S'inscrire</a>
            </li>
            <?php } ?>
        <?php }else{ ?>
            <li class="nav-item">
              <a class="nav-link <?php if($pageActuelle == 'profil.php'){ echo 'active'; } ?>" href="profil.php?id=<?= htmlspecialchars($_SESSION['id']); ?>">Profil</a>
            </li>
            <li class="nav-item">
              <a class="nav-link <?php if($pageActuelle == 'emprunts.php'){ echo 'active'; } ?>" href="emprunts.php?id=<?= htmlspecialchars($_SESSION['id']); ?>">Emprunts</a>
            </li>
        <?php } if(isset($_SESSION['auth']) AND $_SESSION['grade'] != 0){ ?>
            <li class="nav-item">
              <a class="nav-link" href="gestion/">Gestion</a>
            </li>
        <?php } ?>
      </ul>
      <form method="get" action="books.php" class="d-flex" role="search">
        <input name="s" class="form-control me-2" type="search" placeholder="Rechercher un livre" aria-label="Rechercher un livre">
        <button class="btn btn-outline-light" type="submit">Rechercher</button>
      </form>
    </div>
  </div>
</nav>
<br />
<br />
<br />