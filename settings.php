<?php
//This file belongs to the Bookfind project.
//
//Bookfind is distributed under the terms of the MIT software license.
//
//Copyright (C) 2025 Chromared
?>

<?php if (isset($_GET['id']) and !empty($_GET['id'])) { ?>
    <?php require 'actions/database.php';
    require 'actions/functions/logFunction.php';
    require 'actions/users/securityAction.php';
    require 'actions/users/showOneUserProfilAction.php';
    require 'actions/functions/selected.php';
    require 'actions/users/updateThemeAction.php';
    ?>
    <!DOCTYPE html>
    <html lang="fr" data-bs-theme="<?php include 'actions/users/decodeThemeAction.php'; ?>">

    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Paramètres</title>
        <?php include 'includes/header.php'; ?>
    </head>

    <body>
        <?php include 'includes/navbar.php'; ?>
        <form method="post">
            <div class="container mt-3">
                <div class="d-flex justify-content-center mt-4">
                    <div class="card text-center mb-3" style="width: 50rem;">
                        <div class="card-body">
                            <h5 class="card-title">Thème <span class="badge text-bg-warning">Bêta</span></h5>
                            <?php if (isset($errorMsg1)) { ?>
                                <div class="alert alert-warning d-flex align-items-center justify-content-center" role="alert">
                                    <i class="bi bi-exclamation-triangle-fill flex-shrink-0 me-2"></i>
                                    <div>
                                        <?= $errorMsg1; ?>
                                    </div>
                                </div>
                            <?php } ?>
                            <?php if (isset($_GET['msg1'])) { ?>
                                <div class="alert alert-success d-flex align-items-center justify-content-center" role="alert">
                                    <i class="bi bi-check-circle-fill flex-shrink-0 me-2"></i>
                                    <div>
                                        Vos modifications ont bien été enregistré.
                                    </div>
                                </div>
                            <?php } ?>
                            <div class="mb-3">
                                <select name="theme" class="form-select" required>
                                    <option value="0" <?php selected($usersInfos['theme'], '0'); ?>>Clair</option>
                                    <option value="1" <?php selected($usersInfos['theme'], '1'); ?>>Sombre</option>
                                    <option value="auto" disabled>Automatique</option>
                                </select>
                            </div>
                            <div class="mb-3">
                                <input type="submit" name="validateTheme" class="btn btn-primary" value="Enregistrer" />
                                <input type="reset" class="btn btn-secondary" value="Réinitialiser" />
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </form>
    </body>

    </html>
<?php } else {
    session_start();
    header('Location: settings.php?id=' . $_SESSION['id']);
} ?>