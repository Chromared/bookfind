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
    <title>BookFind — Rules</title>
    <?php include 'includes/header.php'; ?>
</head>

<body>
    <?php include 'includes/navbar.php'; ?>
    <main class="page">
        <div class="container">
            <div class="narrow prose">
                <h1>BookFind rules</h1>
                <p class="lead">These rules define how BookFind should be used to ensure a safe, respectful and useful environment for all users.</p>
                <p class="text-subtle">The example lists on this page are provided for informational purposes and are not exhaustive.</p>

                <section>
                    <h2>1. Respect for users</h2>
                    <p>Every user must behave respectfully toward other members of the service. Insulting, discriminatory, aggressive or defamatory remarks are prohibited.</p>
                </section>

                <section>
                    <h2>2. Account use</h2>
                    <p>The user account is personal. The user is responsible for all actions performed with their credentials and must keep their login information confidential.</p>
                </section>

                <section>
                    <h2>3. Data and content</h2>
                    <p>Information entered in BookFind must be accurate, relevant and consistent with the platform's intended use. Any attempt at fraud, circumventing the rules or unauthorized modification of content is prohibited.</p>
                </section>

                <section>
                    <h2>4. Service availability</h2>
                    <p>BookFind may be temporarily interrupted for maintenance, update or security reasons. The team reserves the right to evolve the service at any time.</p>
                </section>

                <section>
                    <h2>5. Sanctions</h2>
                    <p>If these rules are not respected, the BookFind team may restrict access to the service, suspend an account or remove the relevant content.</p>
                </section>

                <section>
                    <h2>6. Contact</h2>
                    <p>For any question about these rules, contact the BookFind administration team through the channels provided by your institution.</p>
                </section>
            </div>
        </div>
    </main>
    <?php include 'includes/footer.php'; ?>
</body>

</html>
