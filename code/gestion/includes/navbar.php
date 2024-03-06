<div class="navbar">
<div class="">
    <ul class="ul-nav">
    <div class="title-nav"></
        <p><li class="li-nav"><a href="">BookFind</a></li></p>
    </div>
    <div class="link-nav">
        <p><li class="li-nav"><a href="../index.php">Quitter la gestion</a></li></p>
    </div>
    <div class="link-nav">
        <p><li class="li-nav"><a href="index.php">Accueil</a></li></p>
    </div>
    <div class="link-nav">
        <p><li class="li-nav"><a href="">Livre</a></li></p>
    </div>
        <?php if ($_SESSION['grade'] == '1') { ?>
    <div class="link-nav">
        <p><li class="li-nav"><a href="">Log</a></li></p>
    </div>
    <?php } ?>
    <div class="button-nav">
        <p><li class="li-nav"><button class="" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aribua-label="Toggle navigation"><i class="fa-solid fa-bars" ></i></button></li></p>
    </div>
</ul></div>
</div>