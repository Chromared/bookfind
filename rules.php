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
    <title><?= bookfind_translate('BookFind — Rules'); ?></title>
    <?php include 'includes/header.php'; ?>
</head>

<body>
    <?php include 'includes/navbar.php'; ?>
    <main class="page">
        <div class="container">
            <div class="narrow prose">
                <h1><?= bookfind_translate('BookFind rules'); ?></h1>
                <p class="lead"><?= bookfind_translate('These rules define how BookFind should be used to ensure a safe, respectful and useful environment for all users.'); ?></p>
                <p class="text-subtle"><?= bookfind_translate('The example lists on this page are provided for informational purposes and are not exhaustive.'); ?></p>

                <section>
                    <h2>1. <?= bookfind_translate('Respect for users'); ?></h2>
                    <p><?= bookfind_translate('Every user must behave respectfully toward other members of the service. Insulting, discriminatory, aggressive or defamatory remarks are prohibited.'); ?></p>
                </section>

                <section>
                    <h2>2. <?= bookfind_translate('Account use'); ?></h2>
                    <p><?= bookfind_translate('The user account is personal. The user is responsible for all actions performed with their credentials and must keep their login information confidential.'); ?></p>
                </section>

                <section>
                    <h2>3. <?= bookfind_translate('Data and content'); ?></h2>
                    <p><?= bookfind_translate("Information entered in BookFind must be accurate, relevant and consistent with the platform's intended use. Any attempt at fraud, circumventing the rules or unauthorized modification of content is prohibited."); ?></p>
                </section>

                <section>
                    <h2>4. <?= bookfind_translate('Service availability'); ?></h2>
                    <p><?= bookfind_translate('BookFind may be temporarily interrupted for maintenance, update or security reasons. The team reserves the right to evolve the service at any time.'); ?></p>
                </section>

                <section>
                    <h2>5. <?= bookfind_translate('Sanctions'); ?></h2>
                    <p><?= bookfind_translate('If these rules are not respected, the BookFind team may restrict access to the service, suspend an account or remove the relevant content.'); ?></p>
                </section>

                <section>
                    <h2>6. <?= bookfind_translate('Contact'); ?></h2>
                    <p><?= bookfind_translate('For any question about these rules, contact the BookFind administration team through the channels provided by your institution.'); ?></p>
                </section>
            </div>
        </div>
    </main>
    <?php include 'includes/footer.php'; ?>
</body>

</html>
