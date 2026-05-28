<?php
//This file belongs to the Bookfind project.
//
//Bookfind is distributed under the terms of the MIT software license.
//
//Copyright (C) 2025 Chromared
?>



<?php if(isset($_POST['databaseValidate'])){
        $newHost = trim($_POST['host'] ?? '');
        $newDbname = trim($_POST['dbname'] ?? '');
        $newUsername = trim($_POST['user'] ?? '');
        $newPassword = $_POST['password'] ?? '';

        $filePath = realpath(__DIR__ . '/../../../actions/database.php');
        if ($filePath === false) {
            $filePath = __DIR__ . '/../../../actions/database.php'; // fallback
        }

        $testOk = false;
        $testBdd = null;
        try {
            $testBdd = new PDO('mysql:host=' . $newHost . ';dbname=' . $newDbname . ';charset=utf8', $newUsername, $newPassword);
            $testBdd->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $testOk = true;
        } catch (PDOException $e) {
            $db_update_msg = 'Connexion impossible avec ces identifiants.';
            $db_update_type = 'danger';
        }

        if ($testOk) {
            $sqlPath = realpath(__DIR__ . '/../../../actions/bookfind.sql');
            if ($sqlPath === false) {
                $sqlPath = __DIR__ . '/../../../actions/bookfind.sql';
            }

            $expectedTables = [];
            if (is_readable($sqlPath)) {
                $sqlContent = file_get_contents($sqlPath);
                if ($sqlContent !== false) {
                    if (preg_match_all('/CREATE TABLE\s+`([^`]+)`/i', $sqlContent, $matches)) {
                        $expectedTables = array_values(array_unique($matches[1]));
                    }
                }
            } else {
                $db_update_msg = 'Impossible de lire actions/bookfind.sql pour vérifier les tables.';
                $db_update_type = 'danger';
                $testOk = false;
            }

            if (empty($db_update_msg) && !empty($expectedTables)) {
                $missingTables = [];
                $checkStmt = $testBdd->prepare('SELECT COUNT(*) FROM information_schema.tables WHERE table_schema = :schema AND table_name = :table');
                foreach ($expectedTables as $t) {
                    $checkStmt->execute(['schema' => $newDbname, 'table' => $t]);
                    $count = (int) $checkStmt->fetchColumn();
                    if ($count === 0) {
                        $missingTables[] = $t;
                    }
                }

                if (!empty($missingTables)) {
                    $db_update_msg = 'Connexion réussie mais tables manquantes : ' . implode(', ', $missingTables) . '. Mise à jour refusée.';
                    $db_update_type = 'danger';
                    $testOk = false;
                }
            }

            if ($testOk) {
                $fileContent = file_get_contents($filePath);
                $fileContent = preg_replace('/\\$host\s*=\s*\'[^\']*\';/', "\$host = '$newHost';", $fileContent);
                $fileContent = preg_replace('/\\$username\s*=\s*\'[^\']*\';/', "\$username = '$newUsername';", $fileContent);
                $fileContent = preg_replace('/\\$password\s*=\s*\'[^\']*\';/', "\$password = '$newPassword';", $fileContent);
                $fileContent = preg_replace('/\\$dbname\s*=\s*\'[^\']*\';/', "\$dbname = '$newDbname';", $fileContent);

                file_put_contents($filePath, $fileContent);

                    if (is_readable($filePath)) {
                        include $filePath;
                    }

                $appBdd = $GLOBALS['bdd'] ?? null;
                if ($appBdd instanceof PDO) {
                    try {
                        $check = $appBdd->prepare("SELECT COUNT(*) FROM information_schema.tables WHERE table_schema = DATABASE() AND table_name = 'logs'");
                        $check->execute();
                        if ((int) $check->fetchColumn() > 0) {
                            SaveLog($appBdd, $_SERVER['REQUEST_URI'], 'Modification de database.php', 'Modification des informations de connexion à la base de donnée');
                        }
                    } catch (Exception $e) {
                    }
                }

                $db_update_msg = 'Informations enregistrées avec succès.';
                $db_update_type = 'success';

                header('Location: bookfind.php?tab=database');
            }
        }

    }