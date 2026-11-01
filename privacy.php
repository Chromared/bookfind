<?php
//This file belongs to the BookFind project.
//
//BookFind is distributed under the terms of the GNU Affero General Public License v3.0.
//
//Copyright (C) 2025 Chromared
?>

<?php require 'actions/functions/sessionInit.php'; ?>

<!DOCTYPE html>
<html lang="en" data-theme="<?php include 'actions/users/decodeThemeAction.php'; ?>">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>BookFind — Privacy policy</title>
    <?php include 'includes/header.php'; ?>
</head>

<body>
    <?php include 'includes/navbar.php'; ?>
    <main class="page">
        <div class="container">
            <div class="narrow prose">
                <h1>Privacy policy</h1>
                <p class="lead">BookFind is committed to protecting users' personal data and to limiting its processing to what is strictly necessary for the service to function.</p>
                <p class="text-subtle">The example lists on this page are provided for informational purposes and are not exhaustive.</p>

                <section>
                    <h2>1. Data collected</h2>
                    <p>Depending on how the service is used, BookFind may process login information, profile data, school data and actions performed in the application.</p>
                </section>

                <section>
                    <h2>2. Purpose of processing</h2>
                    <p>Data is used to provide access to the service, manage accounts, administer loans, ensure security and produce the functions needed for BookFind to operate.</p>
                </section>

                <section>
                    <h2>3. Retention</h2>
                    <p>Data is kept for as long as needed to use the service, to comply with the institution's obligations and to technically manage the platform.</p>
                </section>

                <section>
                    <h2>4. Data sharing</h2>
                    <p>BookFind does not share personal data with unauthorized third parties. Access is limited to authorized people according to their role in the application or the institution.</p>
                </section>

                <section>
                    <h2>5. Security</h2>
                    <p>Technical and organizational measures are in place to limit unauthorized access, protect accounts and preserve the integrity of stored information.</p>
                </section>

                <section>
                    <h2>6. Contact</h2>
                    <p>For any request related to your personal data, contact the BookFind team or your institution's administration according to the current procedure.</p>
                </section>
            </div>
        </div>
    </main>
    <?php include 'includes/footer.php'; ?>
</body>

</html>
