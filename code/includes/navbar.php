<div class="navbar">
<button class="nav-button" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aribua-label="Toggle navigation"></button>
<div class="collapse navbar-collapse" id="navbarSupportedContent">
    <ul class="ul-nav"><div class="title-nav"></
        <p><li class="li-nav"><a href="#">BookFind</a></li></p>
    </div>
    <div class="link-nav">
        <p><li class="li-nav"><a href="index.php">Accueil</a></li></p>
    </div>
    <?php if (!isset($_SESSION['auth'])) { ?>
    <div class="link-nav">
        <p><li class="li-nav"><a href="login.php">Se connecter</a></li></p>
    </div>
    <div class="link-nav">
        <p><li class="li-nav"><a href="signup.php">S'inscrire</a></li></p>
    </div>
    <?php } elseif (isset($_SESSION['auth'])) { ?>
    <div class="link-nav">
        <p><li class="li-nav"><a href="profil.php">Mon profil</a></li></p>
    </div>
    <div class="link-nav">
        <p><li class="li-nav"><a href="">Mes emprunts</a></li></p>
    </div>
        <?php if ($_SESSION['grade'] > '0') { ?>
            <div class="link-nav">
                <p><li class="li-nav"><a href="">Gérer le C.D.I</a></li></p>
            </div>
        <?php } elseif ($_SESSION['grade'] == '1') { ?>
            <div class="link-nav">
                <p><li class="li-nav"><a href="">Gérer BookFind</a></li></p>
            </div>
    <?php }} ?>
</div></ul>
