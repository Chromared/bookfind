<?php
//This file belongs to the Bookfind project.
//
//Bookfind is distributed under the terms of the MIT software license.
//
//Copyright (C) 2025 Chromared
?>



<?php // Importation des utilisateurs via CSV

// Initialisation des variables
$msgImport = "";
$alertImportType = "warning";

// Récupération de la connexion à la base de données (utilisée globalement)
global $bdd;

// Nettoyage automatique des fichiers temporaires de plus de 24 heures
$tempDir = __DIR__ . '/../../../temp';
if (is_dir($tempDir)) {
    $files = glob($tempDir . '/csv_import_*.csv');
    $maxAge = 24 * 60 * 60; // 24 heures
    $now = time();

    foreach ($files as $file) {
        if (is_file($file) && ($now - filemtime($file)) > $maxAge) {
            @unlink($file);
        }
    }
}

// Étape 1: Upload et analyse du CSV
if(isset($_POST['csvUpload'])) {
    if(!isset($_FILES['csvFile']) || $_FILES['csvFile']['error'] !== UPLOAD_ERR_OK) {
        $msgImport = "Erreur lors du téléchargement du fichier. Veuillez réessayer.";
    } else {
        $separator = $_POST['csvSeparator'] ?? ',';
        $hasHeaders = isset($_POST['csvHasHeaders']) ? (int)$_POST['csvHasHeaders'] : 1;
        $_SESSION['csv_has_headers'] = $hasHeaders;

        // Correction pour la tabulation
        if ($separator === '\t') {
            $separator = "\t";
        }

        $csvFile = $_FILES['csvFile']['tmp_name'];

        // Vérification de l'existence du fichier
        if (!file_exists($csvFile)) {
            $msgImport = "Le fichier téléchargé est introuvable. Veuillez réessayer.";
        } else {
            // Vérification du format CSV
            $fileType = mime_content_type($csvFile);
            if ($fileType !== 'text/csv' && $fileType !== 'text/plain') {
                $msgImport = "Le fichier doit être au format CSV.";
            } else {
                // Lecture du fichier CSV
                $csvData = [];
                $headers = [];

                if (($handle = @fopen($csvFile, "r")) !== FALSE) {
                    // Lire la première ligne
                    $firstLine = fgetcsv($handle, 0, $separator, '"', "\\");

                    if (!$firstLine) {
                        $msgImport = "Impossible de lire le fichier CSV.";
                        fclose($handle);
                    } else {
                        if ($hasHeaders) {
                            // Utiliser la première ligne comme en-têtes
                            $headers = $firstLine;
                        } else {
                            // Créer des en-têtes génériques avec aperçu de la première ligne
                            $headers = array_map(function($i, $value) {
                                return "Colonne $i : " . (isset($value) ? substr($value, 0, 15) . (strlen($value) > 15 ? '...' : '') : '');
                            }, array_keys($firstLine), $firstLine);

                            // Traiter la première ligne comme des données
                            $csvData[] = $firstLine;
                        }

                        // Lire les données (max 5 lignes pour aperçu)
                        $previewRows = count($csvData); // 0 ou 1 selon si on a déjà ajouté la première ligne
                        while (($data = fgetcsv($handle, 0, $separator, '"', "\\")) !== FALSE && $previewRows < 5) {
                            $csvData[] = $data;
                            $previewRows++;
                        }

                        // Continuer à lire le reste des données sans stockage (juste pour compter)
                        $totalRows = $previewRows;
                        while (($data = fgetcsv($handle, 0, $separator, '"', "\\")) !== FALSE) {
                            $totalRows++;
                        }

                        fclose($handle);

                        // Créer un dossier temporaire dédié si nécessaire
                        $tempDir = __DIR__ . '/../../../temp';
                        if (!is_dir($tempDir)) {
                            @mkdir($tempDir, 0755, true);
                        }

                        // Générer un nom de fichier unique avec timestamp
                        $uniqueId = uniqid('csv_import_', true);
                        $tempFile = $tempDir . '/' . $uniqueId . '.csv';

                        if (@copy($csvFile, $tempFile)) {
                            // Stocker uniquement les métadonnées dans la session (pas les données)
                            $_SESSION['csv_headers'] = $headers;
                            $_SESSION['csv_separator'] = $separator;
                            $_SESSION['csv_file'] = $tempFile;
                            $_SESSION['total_rows'] = $totalRows;
                            $_SESSION['csv_preview'] = $csvData; // Seulement 5 lignes pour l'aperçu

                            $msgImport = "Fichier CSV analysé avec succès. $totalRows lignes trouvées. Veuillez associer les colonnes.";
                            $alertImportType = "success";
                        } else {
                            $msgImport = "Erreur lors du traitement du fichier. Veuillez réessayer.";
                        }
                    }
                } else {
                    $msgImport = "Impossible d'ouvrir le fichier CSV.";
                }
            }
        }
    }
}

// Annulation de l'importation
if(isset($_POST['csvCancel'])) {
    if (isset($_SESSION['csv_file']) && file_exists($_SESSION['csv_file'])) {
        @unlink($_SESSION['csv_file']);
    }

    unset($_SESSION['csv_headers']);
    unset($_SESSION['csv_separator']);
    unset($_SESSION['csv_file']);
    unset($_SESSION['total_rows']);
    unset($_SESSION['csv_has_headers']);
    unset($_SESSION['csv_preview']);

    $msgImport = "Importation annulée.";
}

// Étape 2: Importation des données
if(isset($_POST['csvImport'])) {
    if(!isset($_SESSION['csv_file']) || !file_exists($_SESSION['csv_file']) || !isset($_SESSION['csv_headers']) || !isset($_SESSION['csv_separator'])) {
        $msgImport = "Aucun fichier CSV en attente d'importation.";
    } else {
        $db_mapping = $_POST['db_mapping'] ?? [];

        // Vérifier le mappage du nom d'utilisateur
        if (!isset($db_mapping['username']) ||
            (isset($db_mapping['username']) && $db_mapping['username'] === 'autre' && empty($_POST['custom_username'])) &&
            $db_mapping['username'] !== 'algorithm') {
            $msgImport = "La correspondance de colonnes est incorrecte. Le champ 'username' est obligatoire.";
        } else {
            // Récupérer les valeurs personnalisées
            $custom_username = isset($_POST['custom_username']) ? trim($_POST['custom_username']) : null;
            $custom_nom = isset($_POST['custom_nom']) ? trim($_POST['custom_nom']) : null;
            $custom_prenom = isset($_POST['custom_prenom']) ? trim($_POST['custom_prenom']) : null;
            $custom_classe = isset($_POST['custom_classe']) ? trim($_POST['custom_classe']) : null;
            $custom_mdp = isset($_POST['custom_mdp']) ? trim($_POST['custom_mdp']) : null;
            $custom_nb_emprunt_max = isset($_POST['custom_nb_emprunt_max']) && is_numeric($_POST['custom_nb_emprunt_max']) ? (int)$_POST['custom_nb_emprunt_max'] : null;

            try {
                // On utilise la connexion $bdd déjà établie dans database.php

                $csvFile = $_SESSION['csv_file'];
                $separator = $_SESSION['csv_separator'];
                $headers = $_SESSION['csv_headers'];
                $hasHeaders = $_SESSION['csv_has_headers'] ?? 1;

                $importedCount = 0;
                $errorCount = 0;
                $errors = [];

                if (($handle = @fopen($csvFile, "r")) !== FALSE) {
                    // Sauter la première ligne si ce sont des en-têtes
                    if ($hasHeaders) {
                        fgetcsv($handle, 0, $separator, '"', "\\");
                    }

                    // Compteur de lignes pour le suivi des erreurs
                    $lineNumber = $hasHeaders ? 2 : 1;

                    while (($data = fgetcsv($handle, 0, $separator, '"', "\\")) !== FALSE) {
                        // Gérer les lignes avec un nombre de colonnes incorrect
                        if (count($data) !== count($headers)) {
                            $errors[] = "Ligne $lineNumber: Nombre de colonnes incorrect";
                            $errorCount++;
                            $lineNumber++;
                            continue;
                        }

                        $userData = [];

                        // Associer les colonnes selon le mapping
                        foreach ($db_mapping as $dbColumn => $csvIndex) {
                            if ($csvIndex !== '' && $csvIndex !== 'autre' && $csvIndex !== 'algorithm' && is_numeric($csvIndex)) {
                                $userData[$dbColumn] = $data[(int)$csvIndex];
                            }
                        }

                        // Traitement du nom et prénom
                        if (isset($db_mapping['nom']) && $db_mapping['nom'] === 'autre') {
                            $userData['nom'] = $custom_nom;
                        } else if (!isset($userData['nom'])) {
                            $userData['nom'] = '';
                        }

                        if (isset($db_mapping['prenom']) && $db_mapping['prenom'] === 'autre') {
                            $userData['prenom'] = $custom_prenom;
                        } else if (!isset($userData['prenom'])) {
                            $userData['prenom'] = '';
                        }

                        // Traitement du nom d'utilisateur
                        if (isset($db_mapping['username']) && $db_mapping['username'] === 'autre') {
                            $userData['username'] = $custom_username;
                        } elseif (isset($db_mapping['username']) && $db_mapping['username'] === 'algorithm') {
                            // Algorithme de génération : première lettre prénom + 7 premières lettres nom
                            if (!empty($userData['prenom']) && !empty($userData['nom'])) {
                                $userData['username'] = strtolower(substr($userData['prenom'], 0, 1) . substr($userData['nom'], 0, 7));
                            } else {
                                $errors[] = "Ligne $lineNumber: Impossible de générer le nom d'utilisateur (nom ou prénom manquant)";
                                $errorCount++;
                                $lineNumber++;
                                continue;
                            }
                        }

                        // Vérifier que l'username n'est pas vide
                        if (empty($userData['username'])) {
                            $errors[] = "Ligne $lineNumber: Nom d'utilisateur vide";
                            $errorCount++;
                            $lineNumber++;
                            continue;
                        }

                        // Traitement de la classe
                        if (isset($db_mapping['classe']) && $db_mapping['classe'] === 'autre') {
                            $userData['classe'] = $custom_classe;
                        } else if (!isset($userData['classe'])) {
                            $userData['classe'] = '';
                        }

                        // Traitement du mot de passe
                        if (isset($db_mapping['mdp']) && $db_mapping['mdp'] === 'autre') {
                            $userData['mdp'] = password_hash($custom_mdp, PASSWORD_DEFAULT);
                        } elseif (!isset($userData['mdp']) || empty($userData['mdp'])) {
                            $userData['mdp'] = password_hash('ChangeMe123!', PASSWORD_DEFAULT);
                        } else {
                            $userData['mdp'] = password_hash($userData['mdp'], PASSWORD_DEFAULT);
                        }

                        // Traitement des valeurs numériques
                        // Grade avec options prédéfinies
                        if (isset($db_mapping['grade']) && is_numeric($db_mapping['grade'])) {
                            $userData['grade'] = (int)$data[(int)$db_mapping['grade']];
                        } else if (isset($db_mapping['grade']) && $db_mapping['grade'] === 'autre' && isset($_POST['custom_grade'])) {
                            $userData['grade'] = (int)$_POST['custom_grade'];
                        } else if (isset($userData['grade'])) {
                            $userData['grade'] = (int)$userData['grade'];
                        } else {
                            $userData['grade'] = 0;
                        }

                        // Règles et PDC à 0 par défaut
                        $userData['regles'] = isset($userData['regles']) ? (int)$userData['regles'] : 0;
                        $userData['pdc'] = isset($userData['pdc']) ? (int)$userData['pdc'] : 0;

                        // Nombre d'emprunts max
                        if (isset($db_mapping['nb_emprunt_max']) && $db_mapping['nb_emprunt_max'] === 'autre') {
                            $userData['nb_emprunt_max'] = $custom_nb_emprunt_max;
                        } elseif (!isset($userData['nb_emprunt_max']) || empty($userData['nb_emprunt_max'])) {
                            $userData['nb_emprunt_max'] = 5;
                        }

                        // Valeurs par défaut additionnelles
                        $userData['nb_emprunt'] = 0;
                        $userData['theme'] = 0;

                        try {
                            // Vérifier si l'utilisateur existe déjà
                            $checkUser = $bdd->prepare('SELECT id FROM users WHERE username = ?');
                            $checkUser->execute([$userData['username']]);

                            if($checkUser->rowCount() > 0) {
                                // Mise à jour de l'utilisateur existant
                                $sql = 'UPDATE users SET ';
                                $params = [];
                                $updates = [];

                                foreach ($userData as $column => $value) {
                                    if ($column !== 'username') {
                                        $updates[] = "$column = ?";
                                        $params[] = $value;
                                    }
                                }

                                $sql .= implode(', ', $updates);
                                $sql .= ' WHERE username = ?';
                                $params[] = $userData['username'];

                                $stmt = $bdd->prepare($sql);
                                $stmt->execute($params);
                            } else {
                                // Insertion d'un nouvel utilisateur
                                $columns = implode(', ', array_keys($userData));
                                $placeholders = implode(', ', array_fill(0, count($userData), '?'));

                                $sql = "INSERT INTO users ($columns) VALUES ($placeholders)";
                                $stmt = $bdd->prepare($sql);
                                $stmt->execute(array_values($userData));
                            }

                            $importedCount++;

                        } catch (PDOException $e) {
                            $errors[] = "Ligne $lineNumber: " . $e->getMessage();
                            $errorCount++;
                        }

                        $lineNumber++;
                    }

                    fclose($handle);

                    // Supprimer le fichier temporaire
                    if (file_exists($_SESSION['csv_file'])) {
                        @unlink($_SESSION['csv_file']);
                    }

                    // Nettoyer la session
                    unset($_SESSION['csv_headers']);
                    unset($_SESSION['csv_separator']);
                    unset($_SESSION['csv_file']);
                    unset($_SESSION['csv_total_rows']);
                    unset($_SESSION['csv_has_headers']);
                    unset($_SESSION['csv_preview']);

                    SaveLog($bdd, $_SERVER['REQUEST_URI'], 'Importation d\'utilisateurs via csv', $importedCount . ' utilisateurs importés');

                    $msgImport = "Importation terminée: $importedCount utilisateurs importés, $errorCount erreurs.";
                    if (!empty($errors)) {
                        $msgImport .= "<br><strong>Détails des erreurs:</strong><ul>";
                        foreach(array_slice($errors, 0, 5) as $error) {
                            $msgImport .= "<li>" . htmlspecialchars($error) . "</li>";
                        }
                        if (count($errors) > 5) {
                            $msgImport .= "<li>..." . (count($errors) - 5) . " autres erreurs</li>";
                        }
                        $msgImport .= "</ul>";
                    }
                    $alertImportType = ($errorCount > 0) ? "warning" : "success";
                } else {
                    $msgImport = "Impossible d'ouvrir le fichier CSV.";
                }
            } catch (PDOException $e) {
                $msgImport = "Erreur de connexion à la base de données: " . htmlspecialchars($e->getMessage());
            }
        }
    }
}

// Retourner au script appelant avec les messages
return [
    'msgImport' => $msgImport,
    'alertImportType' => $alertImportType
];