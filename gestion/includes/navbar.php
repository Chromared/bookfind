# This file belongs to the Bookfind project.
#
# Bookfind is distributed under the terms of the MIT software license.
#
# Copyright (C) 2024 Chromared


<div class="navbar">
<div class="">
    <nav>

    
        <ul class="sidebar">
            <li onclick=hideSidebar()><a href="#"><i class="fa-solid fa-xmark" style="color: #FFD43B;"></i></a></li>
            <li><a href="index.php">Accueil</a></li>

            <li><a href="../index.php">Quitter la Gestion</a></li>
            <li class="li-nav"><a href="books.php">Livres</a></li>

            <li><a href="users.php">Utilisateurs</a></li>

            <?php if ($_SESSION['grade'] == '1') { ?>
                <li><a href="log.php">Logs</a></li>
            <?php } ?>

        </ul>
        <ul>
                <li><a href="index.php"><img src="../style/img/logopourpage.png" alt="logo" class="logo"></a></li>
                <li class="hideOnMobile"><a href="index.php">Accueil</a></li>
                <li class="hideOnMobile"><a href="books.php">Livres</a></li>
                <li class="hideOnMobile"><a href="emprunts.php">Emprunts</a></li>
                <li class="hideOnMobile"><a href="add-books.php">Ajouter un livre</a></li>
                <li class="hideOnMobile"><a href="users.php">Utilisateurs</a></li>

            <?php if ($_SESSION['grade'] == '1') { ?>
                <li class="hideOnMobile"><a href="log.php">Logs</a></li>
            <?php } ?>
            <li class="hideOnMobile"><a href="../index.php">Quitter la gestion</a></li>

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