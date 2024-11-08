# X11 License
# Copyright © 2024 Chromared


<div class="navbar">
<div class="">
    <nav>
        <!--<div class="logo">
            <a href="index.html" class="anav"><img src="./style/img/logopourpage.png" alt="beg"></img> Bookfind</a>
        </div>-->
    
        <ul class="sidebar">
            <li onclick=hideSidebar()><a href="#"><i class="fa-solid fa-xmark" style="color: #FFD43B;"></i></a></li>
            <li><a href="index.php">Accueil</a></li>

            <?php if (!isset($_SESSION['auth'])) { ?>
                <li><a href="login.php">Se connecter</a></li>
                <li class="li-nav"><a href="signup.php">S'inscrire</a></li>

            <?php } elseif (isset($_SESSION['auth'])) { ?>
                <li><a href="profil.php?id=<?= htmlspecialchars($_SESSION['id']); ?>">Mon profil</a></li>
                <li><a href="">Mes emprunts</a></li>

            <?php if ($_SESSION['grade'] > '0') { ?>
                <li><a href="gestion/index.php">Gestion</a></li>
            <?php }} ?>

        </ul>
        <ul>
            <li><a href="index.php"><img src="./style/img/logopourpage.png" alt="logo" class="logo"></a></li>
            <li class="hideOnMobile"><a href="index.php">Accueil</a></li>

            <?php if (!isset($_SESSION['auth'])) { ?>
                <li class="hideOnMobile"><a href="login.php">Se connecter</a></li>
                <li class="hideOnMobile"><a href="signup.php">S'inscrire</a></li>

            <?php } elseif (isset($_SESSION['auth'])) { ?>
                <li class="hideOnMobile"><a href="profil.php?id=<?= htmlspecialchars($_SESSION['id']); ?>">Mon profil</a></li>
                <li class="hideOnMobile"><a href="emprunts.php?card=<?= htmlspecialchars($_SESSION['card']); ?>">Mes emprunts</a></li>

            <?php if ($_SESSION['grade'] > '0') { ?>
                <li class="hideOnMobile"><a href="gestion/index.php">Gestion</a></li>
            <?php }} ?>

                <li class="menu-button" onclick=showSidebar()><a href="#"><i class="fa-solid fa-bars" style="color: #FFD43B;"></i></a></li>
        </ul>
    </nav>
    <script>
        function showSidebar() {
            const sidebar = document.querySelector('.sidebar')
            sidebar.style.display = 'flex'
        }
        function hideSidebar() {
            const sidebar = document.querySelector('.sidebar')
            sidebar.style.display = 'none'
        }
    </script>
</div>
</div>
<br />