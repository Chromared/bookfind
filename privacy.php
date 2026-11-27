<?php
//This file belongs to the BookFind project.
//Copyright (C) 2026 Chromared
//
//This program is free software: you can redistribute it and/or modify
//it under the terms of the GNU Affero General Public License as
//published by the Free Software Foundation, either version 3 of the
//License, or (at your option) any later version.
//
//This program is distributed in the hope that it will be useful,
//but WITHOUT ANY WARRANTY; without even the implied warranty of
//MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
//GNU Affero General Public License for more details.
//
//You should have received a copy of the GNU Affero General Public License
//along with this program.  If not, see <https://www.gnu.org/licenses/>.
?>

<?php require 'actions/functions/sessionInit.php'; ?>

<!DOCTYPE html>
<html lang="<?= $GLOBALS['bookfindLocale'] === 'fr_FR' ? 'fr' : 'en'; ?>" data-theme="<?php include 'actions/users/decodeThemeAction.php'; ?>">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= bookfind_translate('BookFind — Privacy policy'); ?></title>
    <?php include 'includes/header.php'; ?>
</head>

<body>
    <?php include 'includes/navbar.php'; ?>
    <main class="page">
        <div class="container">
            <div class="narrow prose">
                <h1><?= bookfind_translate('Privacy policy'); ?></h1>
                <p class="lead"><?= bookfind_translate("BookFind is committed to protecting users' personal data and to limiting its processing to what is strictly necessary for the service to function."); ?></p>
                <p class="text-subtle"><?= bookfind_translate('The example lists on this page are provided for informational purposes and are not exhaustive.'); ?></p>

                <section>
                    <h2>1. <?= bookfind_translate('Data collected'); ?></h2>
                    <p><?= bookfind_translate('Depending on how the service is used, BookFind may process login information, profile data, school data and actions performed in the application.'); ?></p>
                </section>

                <section>
                    <h2>2. <?= bookfind_translate('Purpose of processing'); ?></h2>
                    <p><?= bookfind_translate('Data is used to provide access to the service, manage accounts, administer loans, ensure security and produce the functions needed for BookFind to operate.'); ?></p>
                </section>

                <section>
                    <h2>3. <?= bookfind_translate('Retention'); ?></h2>
                    <p><?= bookfind_translate("Data is kept for as long as needed to use the service, to comply with the institution's obligations and to technically manage the platform."); ?></p>
                </section>

                <section>
                    <h2>4. <?= bookfind_translate('Data sharing'); ?></h2>
                    <p><?= bookfind_translate('BookFind does not share personal data with unauthorized third parties. Access is limited to authorized people according to their role in the application or the institution.'); ?></p>
                </section>

                <section>
                    <h2>5. <?= bookfind_translate('Security'); ?></h2>
                    <p><?= bookfind_translate('Technical and organizational measures are in place to limit unauthorized access, protect accounts and preserve the integrity of stored information.'); ?></p>
                </section>

                <section>
                    <h2>6. <?= bookfind_translate('Contact'); ?></h2>
                    <p><?= bookfind_translate("For any request related to your personal data, contact the BookFind team or your institution's administration according to the current procedure."); ?></p>
                </section>
            </div>
        </div>
    </main>
    <?php include 'includes/footer.php'; ?>
</body>

</html>
