<?php if(isset($_POST['databaseValidate'])){
        $newHost = $_POST['host'];
        $newDbname = $_POST['dbname'];
        $newUsername = $_POST['user'];
        $newPassword = $_POST['password'];

        $filePath = '../actions/database.php'; //car exécuté depuis le fichier bookfind.php
                                
        $fileContent = file_get_contents($filePath);
    
        $fileContent = preg_replace("/\\\$host = 'localhost';/", "\$host = '$newHost';", $fileContent);
        $fileContent = preg_replace("/\\\$username = 'root';/", "\$username = '$newUsername';", $fileContent);
        $fileContent = preg_replace("/\\\$password = '';/", "\$password = '$newPassword';", $fileContent);
        $fileContent = preg_replace("/\\\$dbname = 'bookfind';/", "\$dbname = '$newDbname';", $fileContent);

        file_put_contents($filePath, $fileContent);

        SaveLog($bdd, $_SERVER['REQUEST_URI'], 'Modification de database.php', 'Modification des informations de connexion à la base de donnée');

        header('Location: bookfind.php');
    }