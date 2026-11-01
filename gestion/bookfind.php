<?php
//This file belongs to the BookFind project.
//
//BookFind is distributed under the terms of the GNU Affero General Public License v3.0.
//
//Copyright (C) 2025 Chromared
?>

<?php
require '../actions/database.php';
require_once '../actions/functions/gettextFunction.php';
require '../actions/users/securityAction.php';

// Centralized access check before loading sensitive actions
if (!isset($_SESSION['grade']) || $_SESSION['grade'] != '1') {
    http_response_code(403);
    require '../errors/403.php';
    exit;
}

require 'actions/users/securityAdminAction.php';
require '../actions/functions/logFunction.php';
require '../actions/functions/generateUsernameFunction.php';
require '../actions/functions/csrfFunction.php';
if (isset($_GET['tab']) && $_GET['tab'] == 'database') {
    require 'actions/others/updateDatabase.php';
} elseif (isset($_GET['tab']) && $_GET['tab'] == 'classes') {
    require 'actions/others/addClass.php';
    require 'actions/others/updateClass.php';
    require 'actions/others/deleteClass.php';
} elseif (isset($_GET['tab']) && $_GET['tab'] == 'users') {
    require 'actions/users/importUsers.php';
    require 'actions/users/regenUsernamesAction.php';
}

if ($_SESSION['grade'] != '1') {
    http_response_code(403);
    require '../errors/403.php';
    exit;
}
if (!isset($_GET['tab']) or !in_array($_GET['tab'], ['database', 'classes', 'users'])) {
    http_response_code(404);
    require '../errors/404.php';
    exit;
}
?>

<!DOCTYPE html>
<html lang="en" data-theme="<?php include '../actions/users/decodeThemeAction.php'; ?>">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>BookFind — Administration</title>
    <?php include '../includes/header.php'; ?>
</head>

<body class="admin">
    <?php include 'includes/navbar.php'; ?>
    <main class="page">
      <div class="container">
        <div class="narrow stack">
        <?php if (isset($_GET['tab']) and $_GET['tab'] == 'database') { ?>
            <!-- Database connection -->
            <form method="POST" autocomplete="off">
                <div class="card">
                    <div class="card__body">
                        <h1 class="card__title">Database connection</h1>
                        <div class="alert alert--info" role="alert">
                            <svg class="icon"><use href="#i-info"/></svg>
                            <div>Fields marked with * are required.</div>
                        </div>
                        <?php if (isset($db_update_msg)) {
                            $type = $db_update_type ?? 'info';
                            $iconClass = '#i-info';
                            if ($type === 'success') $iconClass = '#i-check';
                            elseif ($type === 'danger' || $type === 'warning') $iconClass = '#i-alert';
                        ?>
                            <div class="alert alert--<?php echo $type ?>" role="alert">
                                <svg class="icon"><use href="<?php echo $iconClass ?>"/></svg>
                                <div><?php echo $db_update_msg; ?></div>
                            </div>
                        <?php } ?>
                        <div class="field">
                            <label for="host" class="label">Host*</label>
                            <input type="text" name="host" id="host" class="input" value="<?php if (isset($host)) {
                                                                                                    echo $host;
                                                                                                } ?>" required />
                        </div>
                        <div class="field">
                            <label for="dbname" class="label">Database name*</label>
                            <input type="text" name="dbname" id="dbname" class="input" value="<?php if (isset($dbname)) {
                                                                                                        echo $dbname;
                                                                                                    } ?>" placeholder="bookfind" required />
                        </div>
                        <div class="field">
                            <label for="user" class="label">Username*</label>
                            <input type="text" name="user" id="user" class="input" value="<?php if (isset($username)) {
                                                                                                    echo $username;
                                                                                                } ?>" required />
                        </div>
                        <div class="field">
                            <label for="password" class="label">Password</label>
                            <input type="password" name="password" id="password" class="input" placeholder="Leave empty to keep the current password" autocomplete="new-password" />
                        </div>
                        <div class="field">
                            <?= csrf_field(); ?>
                            <input type="submit" name="databaseValidate" class="btn btn--primary" value="Save" />
                        </div>
                    </div>
                </div>
            </form>
        <?php } elseif (isset($_GET['tab']) and $_GET['tab'] == 'classes') { ?>

            <!-- Add a class -->
            <form method="POST" autocomplete="off" id="addClass">
                <?= csrf_field(); ?>
                <div class="card">
                    <div class="card__body">
                        <h1 class="card__title">Add a class</h1>
                        <div class="alert alert--info" role="alert">
                            <svg class="icon"><use href="#i-info"/></svg>
                            <div>Fields marked with * are required.</div>
                        </div>
                        <?php if (isset($msgC1)) { ?>
                            <div class="alert alert--warning" role="alert">
                                <svg class="icon"><use href="#i-alert"/></svg>
                                <div><?= $msgC1; ?></div>
                            </div>
                        <?php } elseif (isset($_GET['successAddClass'])) { ?>
                            <div class="alert alert--success" role="alert">
                                <svg class="icon"><use href="#i-check"/></svg>
                                <div>Class added successfully</div>
                            </div>
                        <?php } ?>
                        <div class="field">
                            <label for="newClass" class="label">New class*</label>
                            <input type="text" name="newClass" id="newClass" class="input" required />
                        </div>
                        <div class="field">
                            <input type="submit" name="classAddValidate" class="btn btn--success" value="Add" />
                        </div>
                    </div>
                </div>
            </form>

            <!-- Edit a class -->
            <form method="POST" autocomplete="off" id="updateClass">
                <?= csrf_field(); ?>
                <div class="card">
                    <div class="card__body">
                        <h2 class="card__title">Edit a class</h2>
                        <div class="alert alert--info" role="alert">
                            <svg class="icon"><use href="#i-info"/></svg>
                            <div>Fields marked with * are required.</div>
                        </div>
                        <?php if (isset($msgC2)) { ?>
                            <div class="alert alert--warning" role="alert">
                                <svg class="icon"><use href="#i-alert"/></svg>
                                <div><?= $msgC2; ?></div>
                            </div>
                        <?php } elseif (isset($_GET['successUpdateClass'])) { ?>
                            <div class="alert alert--success" role="alert">
                                <svg class="icon"><use href="#i-check"/></svg>
                                <div>Class modified successfully</div>
                            </div>
                        <?php } ?>
                        <div class="field">
                            <label for="existingClass" class="label">Existing class*</label>
                            <select name="existingClass" id="existingClass" class="select" required>
                                <option value=""><?php echo _('--- Select a class ---'); ?></option>
                                <?php include '../actions/functions/getClassesAndOptions.php'; ?>
                            </select>
                        </div>
                        <div class="field">
                            <label for="newClassName" class="label">New class name*</label>
                            <input type="text" name="newClassName" id="newClassName" class="input" required />
                        </div>
                        <div class="field">
                            <input type="submit" name="classUpdateValidate" class="btn btn--primary" value="Edit" />
                        </div>
                    </div>
                </div>
            </form>

            <!-- Delete a class -->
            <form method="POST" autocomplete="off" id="deleteClass">
                <?= csrf_field(); ?>
                <div class="card">
                    <div class="card__body">
                        <h2 class="card__title">Delete a class</h2>
                        <div class="alert alert--info" role="alert">
                            <svg class="icon"><use href="#i-info"/></svg>
                            <div>Fields marked with * are required.</div>
                        </div>
                        <?php if (isset($msgC3)) { ?>
                            <div class="alert alert--warning" role="alert">
                                <svg class="icon"><use href="#i-alert"/></svg>
                                <div><?= $msgC3; ?></div>
                            </div>
                        <?php } elseif (isset($_GET['successDeleteClass'])) { ?>
                            <div class="alert alert--success" role="alert">
                                <svg class="icon"><use href="#i-check"/></svg>
                                <div>Class deleted successfully</div>
                            </div>
                        <?php } ?>
                        <div class="field">
                            <label for="existingClass2" class="label">Class to delete*</label>
                            <select name="existingClass2" id="existingClass2" class="select" required>
                                <option value=""><?php echo _('--- Select a class ---'); ?></option>
                                <?php include '../actions/functions/getClassesAndOptions.php'; ?>
                            </select>
                        </div>
                        <div class="field">
                            <input type="submit" name="classDeleteValidate" class="btn btn--danger" value="Delete" />
                        </div>
                    </div>
                </div>
            </form>
        <?php } elseif (isset($_GET['tab']) and $_GET['tab'] == 'users') { ?>
            <!-- Import users via CSV -->
            <form method="POST" enctype="multipart/form-data" autocomplete="off" action="bookfind.php?tab=users">
                <?= csrf_field(); ?>
                <div class="card">
                    <div class="card__body">
                        <h1 class="card__title"><?php echo _('Import users from a CSV'); ?></h1>
                        <div class="alert alert--info" role="alert">
                            <svg class="icon"><use href="#i-info"/></svg>
                            <div><?php echo _('Choose a CSV file containing the user data to import.'); ?></div>
                        </div>

                        <?php if (isset($msgImport) and !empty($msgImport)) { ?>
                            <div class="alert alert--<?= htmlspecialchars($alertImportType ?? 'warning', ENT_QUOTES, 'UTF-8') ?>" role="alert">
                                <svg class="icon"><use href="#i-alert"/></svg>
                                <div><?= $msgImport; ?></div>
                            </div>
                        <?php } ?>

                        <?php if (!isset($_SESSION['csv_preview'])): ?>
                            <!-- CSV upload form -->
                            <div class="field">
                                <label for="csvFile" class="label"><?php echo _('CSV file'); ?></label>
                                <input type="file" name="csvFile" id="csvFile" class="input" accept=".csv" required />
                            </div>
                            <div class="field">
                                <label for="csvSeparator" class="label"><?php echo _('CSV separator'); ?></label>
                                <select name="csvSeparator" id="csvSeparator" class="select">
                                    <option value=",">Comma (,)</option>
                                    <option value=";">Semicolon (;)</option>
                                    <option value="\t">Tab</option>
                                    <option value="|">Vertical bar (|)</option>
                                </select>
                            </div>
                            <div class="field">
                                <span class="label"><?php echo _('CSV file format'); ?></span>
                                <label class="check">
                                    <input type="radio" name="csvHasHeaders" id="csvHasHeaders1" value="1" checked>
                                    <?php echo _('First line = headers (do not import)'); ?>
                                </label>
                                <label class="check mt-1">
                                    <input type="radio" name="csvHasHeaders" id="csvHasHeaders0" value="0">
                                    <?php echo _('First line = data (to import)'); ?>
                                </label>
                            </div>
                            <div class="field">
                                <input type="submit" name="csvUpload" class="btn btn--primary" value="<?php echo _('Upload and analyze'); ?>" />
                            </div>
                        <?php else: ?>
                            <div class="field">
                                <h2 class="card__title" style="font-size:16px;"><?php echo _('Column mapping'); ?></h2>
                                <p class="hint"><?php echo _('For each database field, select the matching column in your CSV.'); ?></p>

                                <!-- Button to switch CSV -->
                                <div class="mb-3" style="text-align:right;">
                                    <input type="submit" name="csvCancel" class="btn btn--outline" value="<?php echo _('Change CSV file'); ?>" />
                                </div>

                                <div class="table-wrap">
                                    <table class="table">
                                        <thead>
                                            <tr>
                                                <th colspan="2"><?php echo _('Basic information'); ?></th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr>
                                                <td><span class="label">Username</span></td>
                                                <td>
                                                    <select name="db_mapping[username]" id="map_username" class="select" onchange="toggleCustomField('username')" required>
                                                        <option value="algorithm"><?php echo _('Use the algorithm (first letter of first name + last name)'); ?></option>
                                                        <optgroup label="<?php echo _('CSV columns'); ?>">
                                                            <?php foreach ($_SESSION['csv_headers'] as $index => $header): ?>
                                                                <option value="<?= $index ?>"><?= htmlspecialchars($header) ?></option>
                                                            <?php endforeach; ?>
                                                        </optgroup>
                                                    </select>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td><span class="label">Last name</span></td>
                                                <td>
                                                    <select name="db_mapping[last_name]" id="map_last_name" class="select" onchange="toggleCustomField('last_name')">
                                                        <option value=""><?php echo _('Not imported'); ?></option>
                                                        <option value="other"><?php echo _('Other value...'); ?></option>
                                                        <optgroup label="<?php echo _('CSV columns'); ?>">
                                                            <?php foreach ($_SESSION['csv_headers'] as $index => $header): ?>
                                                                <option value="<?= $index ?>"><?= htmlspecialchars($header) ?></option>
                                                            <?php endforeach; ?>
                                                        </optgroup>
                                                    </select>
                                                    <div id="custom_last_name_div" class="mt-2" style="display: none;">
                                                        <input type="text" name="custom_last_name" id="custom_last_name" class="input" placeholder="<?php echo _('Last name'); ?>">
                                                    </div>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td><span class="label">First name</span></td>
                                                <td>
                                                    <select name="db_mapping[first_name]" id="map_first_name" class="select" onchange="toggleCustomField('first_name')">
                                                        <option value=""><?php echo _('Not imported'); ?></option>
                                                        <option value="other"><?php echo _('Other value...'); ?></option>
                                                        <optgroup label="<?php echo _('CSV columns'); ?>">
                                                            <?php foreach ($_SESSION['csv_headers'] as $index => $header): ?>
                                                                <option value="<?= $index ?>"><?= htmlspecialchars($header) ?></option>
                                                            <?php endforeach; ?>
                                                        </optgroup>
                                                    </select>
                                                    <div id="custom_first_name_div" class="mt-2" style="display: none;">
                                                        <input type="text" name="custom_first_name" id="custom_first_name" class="input" placeholder="<?php echo _('First name'); ?>">
                                                    </div>
                                                </td>
                                            </tr>
                                        </tbody>

                                        <thead>
                                            <tr>
                                                <th colspan="2"><?php echo _('Class'); ?></th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr>
                                                <td><span class="label">Class</span></td>
                                                <td>
                                                    <select name="db_mapping[class_name]" id="map_class_name" class="select" onchange="toggleCustomField('class_name')">
                                                        <option value=""><?php echo _('Not imported'); ?></option>
                                                        <option value="other"><?php echo _('Other value...'); ?></option>
                                                        <optgroup label="<?php echo _('CSV columns'); ?>">
                                                            <?php foreach ($_SESSION['csv_headers'] as $index => $header): ?>
                                                                <option value="<?= $index ?>"><?= htmlspecialchars($header) ?></option>
                                                            <?php endforeach; ?>
                                                        </optgroup>
                                                    </select>
                                                    <div id="custom_class_name_div" class="mt-2" style="display: none;">
                                                        <select name="custom_class_name" id="custom_class_name" class="select">
                                                            <option value=""><?php echo _('--- Select a class ---'); ?></option>
                                                            <?php
                                                            $selectClasses = $db->query('SELECT name FROM classes');
                                                            while ($classes = $selectClasses->fetch()) {
                                                                echo '<option value="' . htmlspecialchars($classes['name']) . '">' . htmlspecialchars($classes['name']) . '</option>';
                                                            }
                                                            ?>
                                                        </select>
                                                    </div>
                                                </td>
                                            </tr>
                                        </tbody>

                                        <thead>
                                            <tr>
                                                <th colspan="2"><?php echo _('User settings'); ?></th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr>
                                                <td><span class="label">Grade</span></td>
                                                <td>
                                                    <select name="db_mapping[grade]" id="map_grade" class="select">
                                                        <option value="fixed:0"><?php echo _('None (0)'); ?></option>
                                                        <option value="fixed:1"><?php echo _('Administrator (1)'); ?></option>
                                                        <option value="fixed:2"><?php echo _('Manager (2)'); ?></option>
                                                        <option value="fixed:3"><?php echo _('Assistant (3)'); ?></option>
                                                        <optgroup label="<?php echo _('CSV columns'); ?>">
                                                            <?php foreach ($_SESSION['csv_headers'] as $index => $header): ?>
                                                                <option value="<?= $index ?>"><?= htmlspecialchars($header) ?></option>
                                                            <?php endforeach; ?>
                                                        </optgroup>
                                                    </select>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td><span class="label">Rules</span></td>
                                                <td>
                                                    <select name="db_mapping[rules_accepted]" id="map_rules" class="select">
                                                        <option value="fixed:0"><?php echo _('Use 0'); ?></option>
                                                        <option value="fixed:1"><?php echo _('Use 1'); ?></option>
                                                        <optgroup label="<?php echo _('CSV columns'); ?>">
                                                            <?php foreach ($_SESSION['csv_headers'] as $index => $header): ?>
                                                                <option value="<?= $index ?>"><?= htmlspecialchars($header) ?></option>
                                                            <?php endforeach; ?>
                                                        </optgroup>
                                                    </select>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td><span class="label">Privacy</span></td>
                                                <td>
                                                    <select name="db_mapping[privacy_accepted]" id="map_privacy_accepted" class="select">
                                                        <option value="fixed:0"><?php echo _('Use 0'); ?></option>
                                                        <option value="fixed:1"><?php echo _('Use 1'); ?></option>
                                                        <optgroup label="<?php echo _('CSV columns'); ?>">
                                                            <?php foreach ($_SESSION['csv_headers'] as $index => $header): ?>
                                                                <option value="<?= $index ?>"><?= htmlspecialchars($header) ?></option>
                                                            <?php endforeach; ?>
                                                        </optgroup>
                                                    </select>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td><span class="label">Max loans</span></td>
                                                <td>
                                                    <select name="db_mapping[max_loans]" id="map_max_loans" class="select" onchange="toggleCustomField('max_loans')">
                                                        <option value="">Use 5</option>
                                                        <option value="other"><?php echo _('Other value...'); ?></option>
                                                        <optgroup label="<?php echo _('CSV columns'); ?>">
                                                            <?php foreach ($_SESSION['csv_headers'] as $index => $header): ?>
                                                                <option value="<?= $index ?>"><?= htmlspecialchars($header) ?></option>
                                                            <?php endforeach; ?>
                                                        </optgroup>
                                                    </select>
                                                    <div id="custom_max_loans_div" class="mt-2" style="display: none;">
                                                        <input type="number" name="custom_max_loans" id="custom_max_loans" class="input" min="1" placeholder="<?php echo _('Maximum'); ?>">
                                                    </div>
                                                </td>
                                            </tr>
                                        </tbody>

                                        <thead>
                                            <tr>
                                                <th colspan="2"><?php echo _('Authentication'); ?></th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr>
                                                <td><span class="label">Password</span></td>
                                                <td>
                                                    <select name="db_mapping[password]" id="map_password" class="select" onchange="toggleCustomField('password')">
                                                        <option value="fixed:default"><?php echo _('Use "ChangeMe123!"'); ?></option>
                                                        <option value="other"><?php echo _('Other value...'); ?></option>
                                                        <optgroup label="<?php echo _('CSV columns'); ?>">
                                                            <?php foreach ($_SESSION['csv_headers'] as $index => $header): ?>
                                                                <option value="<?= $index ?>"><?= htmlspecialchars($header) ?></option>
                                                            <?php endforeach; ?>
                                                        </optgroup>
                                                    </select>
                                                    <div id="custom_password_div" class="mt-2" style="display: none;">
                                                        <input type="password" name="custom_password" id="custom_password" class="input" placeholder="<?php echo _('Password'); ?>" autocomplete="new-password">
                                                    </div>
                                                </td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>

                                <div class="alert alert--info mt-3">
                                    <svg class="icon"><use href="#i-info"/></svg>
                                    <div><small><?= sprintf(_('Preview: %1$d of %2$d rows displayed.'), count($_SESSION['csv_preview']), $_SESSION['total_rows']); ?></small></div>
                                </div>
                            </div>
                            <div class="btn-group">
                                <input type="submit" name="csvImport" class="btn btn--success" value="<?php echo _('Import users'); ?>" />
                                <input type="submit" name="csvCancel" class="btn btn--secondary" value="<?php echo _('Cancel'); ?>" />
                            </div>
                        <?php endif; ?>
                    </div>
                </div>
            </form>
            <script nonce="<?= htmlspecialchars($_SESSION['csp_nonce'] ?? '') ?>">
                function toggleCustomField(field) {
                    const selectElement = document.getElementById(`map_${field}`);
                    const customDiv = document.getElementById(`custom_${field}_div`);

                    if (selectElement && customDiv) {
                        if (selectElement.value === 'other') {
                            customDiv.style.display = 'block';
                        } else {
                            customDiv.style.display = 'none';
                        }
                    }
                }
            </script>

            <!-- Regenerate usernames -->
            <form method="POST">
                <?= csrf_field(); ?>
                <div class="card">
                    <div class="card__body">
                        <h2 class="card__title"><?php echo _('Regenerate usernames'); ?></h2>
                        <?php if (isset($msgRegenUsernames)) { ?>
                            <div class="alert alert--<?= ($regenUsernamesSuccess ?? true) ? 'success' : 'danger' ?>" role="alert">
                                <svg class="icon"><use href="<?= ($regenUsernamesSuccess ?? true) ? '#i-check' : '#i-alert' ?>"/></svg>
                                <div><?= htmlspecialchars($msgRegenUsernames, ENT_QUOTES, 'UTF-8'); ?></div>
                            </div>
                        <?php } ?>
                        <div class="field">
                            <button type="submit" name="regenUsernames" class="btn btn--primary"><?php echo _('Regenerate usernames'); ?></button>
                        </div>
                    </div>
                </div>
            </form>
        <?php } ?>
        </div>
      </div>
    </main>
    <?php include '../includes/footer.php'; ?>
</body>

</html>
