<div class="navbar">
    <div class="titre-nav">
        <p><a href="">BookFind</a></p>
    </div>
    <div class="link-nav">
        <p><a href="">Accueil</a></p>
    </div>
    <?php if (!isset($_SESSION['auth'])) { ?>
    <div class="link-nav">
        <p><a href="">Se connecter</a></p>
    </div>
    <div class="link-nav">
        <p><a href="">S'inscrire</a></p>
    </div>
    <?php } elseif (isset($_SESSION['auth'])) { ?>
    <div class="link-nav">
        <p><a href="">Mon profil</a></p>
    </div>
    <div class="link-nav">
        <p><a href="">Mes réservations</a></p>
    </div>
        <?php if ($_SESSION['grade'] == '2') { ?>
            <div class="link-nav">
                <p><a href="">Gérer le C.D.I</a></p>
            </div>
        <?php } elseif ($_SESSION['grade'] == '1') { ?>
            <div class="link-nav">
                <p><a href="">Gérer BookFind</a></p>
            </div>
    <?php }} ?>
</div>