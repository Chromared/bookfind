<?php
//This file belongs to the BookFind project.
//
//BookFind is distributed under the terms of the GNU Affero General Public License v3.0.
//
//Copyright (C) 2025 Chromared
?>

<?php if (isset($_GET['id']) and !empty($_GET['id'])) { ?>
    <?php require 'actions/database.php';
    require 'actions/functions/logFunction.php';
    require 'actions/users/securityAction.php';
    require 'actions/users/showOneUserProfileAction.php';
    require 'actions/functions/selected.php';
    require 'actions/users/updateThemeAction.php';
    ?>
    <!DOCTYPE html>
    <html lang="en" data-theme="<?php include 'actions/users/decodeThemeAction.php'; ?>">

    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>BookFind — Settings</title>
        <?php include 'includes/header.php'; ?>
    </head>

    <body>
        <?php include 'includes/navbar.php'; ?>
        <main class="page">
            <div class="container">
                <div class="narrow">
                    <form method="post">
                        <?= csrf_field(); ?>
                        <div class="card">
                            <div class="card__body">
                                <h1 class="card__title">Theme <span class="badge badge--warning">Beta</span></h1>
                                <?php if (isset($errorMsg1)) { ?>
                                    <div class="alert alert--warning" role="alert">
                                        <svg class="icon"><use href="#i-alert"/></svg>
                                        <div><?= $errorMsg1; ?></div>
                                    </div>
                                <?php } ?>
                                <?php if (isset($_GET['msg1'])) { ?>
                                    <div class="alert alert--success" role="alert">
                                        <svg class="icon"><use href="#i-check"/></svg>
                                        <div>Your changes have been saved.</div>
                                    </div>
                                <?php } ?>
                                <div class="field">
                                    <label for="theme" class="label">Appearance</label>
                                    <select name="theme" id="theme" class="select" required>
                                        <option value="0" <?php selected($usersInfos['theme'], '0'); ?>>Dark (default)</option>
                                        <option value="1" <?php selected($usersInfos['theme'], '1'); ?>>Light</option>
                                    </select>
                                </div>
                                <div class="btn-group">
                                    <input type="submit" name="validateTheme" class="btn btn--primary" value="Save" />
                                    <input type="reset" class="btn btn--secondary" value="Reset" />
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </main>
        <?php include 'includes/footer.php'; ?>
    </body>

    </html>
<?php } else {
    require 'actions/functions/sessionInit.php';
    header('Location: settings.php?id=' . $_SESSION['id']);
} ?>
