<?php
//This file belongs to the Bookfind project.
//
//Bookfind is distributed under the terms of the MIT software license.
//
//Copyright (C) 2024 Chromared
?>



    <nav>

    
        <ul class="sidebar">
            <li onclick=hideSidebar()><a href="#"><i class="fa-solid fa-xmark" style="color: #FFD43B;"></i></a></li>
            <li><a href="index.php">Accueil</a></li>
            <li><a href="books.php">Livres</a></li>
            <li><a href="add-books.php">Ajouter un livre</a></li>
            <li><a href="users.php">Utilisateurs</a></li>

            <?php if ($_SESSION['grade'] == 1 OR $_SESSION['grade'] == 2) { ?>
                <!--<li><a href="cdi.php">C.D.I</a></li>-->
            <?php } ?>

            <?php if ($_SESSION['grade'] == 1) { ?>
                <li><a href="bookfind.php">BookFind</a></li>
                <li><a href="logs.php">Logs</a></li>
            <?php } ?>

            <li><a href="../index.php">Quitter la gestion</a></li>
        </ul>
        <ul>
                <li><a href="index.php"><img src="../style/img/logopourpage.png" alt="logo" class="logo"></a></li>
                <li class="hideOnMobileGestion"><a href="index.php">Accueil</a></li>
                <li class="hideOnMobileGestion"><a href="books.php">Livres</a></li>
                <li class="hideOnMobileGestion"><a href="add-books.php">Ajouter un livre</a></li>
                <li class="hideOnMobileGestion"><a href="users.php">Utilisateurs</a></li>

                <?php if ($_SESSION['grade'] == 1 OR $_SESSION['grade'] == 2) { ?>
                <!--<li class="hideOnMobileGestion"><a href="cdi.php">C.D.I</a></li>-->
            <?php } ?>

            <?php if ($_SESSION['grade'] == 1) { ?>
                <li class="hideOnMobileGestion"><a href="bookfind.php">BookFind</a></li>
                <li class="hideOnMobileGestion"><a href="logs.php">Logs</a></li>
            <?php } ?>

            <li class="hideOnMobileGestion"><a href="../index.php">Quitter la gestion</a></li>

            <li class="menu-buttonGestion" onclick=showSidebar()><a href="#"><i class="fa-solid fa-bars" style="color: #FFD43B;"></i></a></li>
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
<br />