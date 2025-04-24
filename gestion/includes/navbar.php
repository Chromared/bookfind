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
      <img src="../style/iconesite.png" alt="BookFind logo" width="30" height="30" class="d-inline-block align-text-top">
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
        <li class="nav-item dropdown">
          <a class="nav-link dropdown-toggle <?php if($pageActuelle == 'books.php' OR $pageActuelle == 'add-book.php' OR $pageActuelle == 'emprunts.php'){ echo 'active'; } ?>" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
            Livres
          </a>
          <ul class="dropdown-menu">
            <li><a class="dropdown-item <?php if($pageActuelle == 'books.php'){ echo 'active'; } ?>" href="books.php">Rechercher</a></li>
            <li><a class="dropdown-item <?php if($pageActuelle == 'add-book.php'){ echo 'active'; } ?>" href="add-book.php">Ajouter</a></li>
            <li><hr class="dropdown-divider"></li>
            <li><a class="dropdown-item <?php if($pageActuelle == 'emprunts.php'){ echo 'active'; } ?>" href="emprunts.php">Emprunts</a></li>
          </ul>
        </li>
        <li class="nav-item">
          <a class="nav-link <?php if($pageActuelle == 'users.php'){ echo 'active'; } ?>" href="users.php">Utilisateurs</a>
        </li>
        <?php if($_SESSION['grade'] == 1){ ?>
        <li class="nav-item">
          <a class="nav-link <?php if($pageActuelle == 'bookfind.php'){ echo 'active'; } ?>" href="bookfind.php">BookFind</a>
        </li>
        <li class="nav-item">
          <a class="nav-link <?php if($pageActuelle == 'logs.php'){ echo 'active'; } ?>" href="logs.php">Logs</a>
        </li>
        <?php } ?>
        <li class="nav-item">
          <a class="nav-link" href="../">Quitter</a>
        </li>
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