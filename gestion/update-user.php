<?php
//This file belongs to the BookFind project.
//
//BookFind is distributed under the terms of the GNU Affero General Public License v3.0.
//
//Copyright (C) 2025 Chromared
?>

<?php if (isset($_GET['id']) and !empty($_GET['id'])) { ?>
  <?php require '../actions/database.php';
  require '../actions/users/securityAction.php';
  require 'actions/users/securityAdminAction.php';
  require '../actions/functions/logFunction.php';
  require '../actions/users/showOneUserProfileAction.php';
  if (($_SESSION['grade'] != '1' and ($usersInfos['grade'] ?? null) == '1') or ($_SESSION['grade'] != '1' and $_SESSION['grade'] != '2' and ($usersInfos['grade'] ?? null) == '2') or $_SESSION['grade'] == '3') {
    http_response_code(403);
    require '../errors/403.php';
    exit;
  } else {
    require '../actions/functions/selected.php';
    require '../actions/functions/gradeIntToText.php';
    require 'actions/users/updatePersonalInfoAction.php';
    require 'actions/users/updateSchoolInfoAction.php';
    require 'actions/users/updateGradeAction.php';
    require 'actions/users/updatePasswordAction.php';
    require 'actions/users/deleteAccountAction1.php';
    require 'actions/users/deleteAccountAction2.php'; ?>
    <!DOCTYPE html>
    <html lang="en" data-theme="<?php include '../actions/users/decodeThemeAction.php'; ?>">

    <head>
      <meta charset="UTF-8">
      <meta name="viewport" content="width=device-width, initial-scale=1.0">
      <title>BookFind — Update user account</title>
      <?php include '../includes/header.php' ?>
    </head>

    <body class="admin">
      <?php include 'includes/navbar.php' ?>
      <main class="page">
        <div class="container">
          <div class="narrow stack">

            <form method="post">
              <?= csrf_field(); ?>
              <div class="card">
                <div class="card__body">
                  <h1 class="card__title">Personal information</h1>
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
                    <label for="firstname" class="label">First name</label>
                    <input type="text" name="firstname" id="firstname" class="input" placeholder="John" value="<?= htmlspecialchars($usersInfos['first_name'] ?? ''); ?>" required />
                  </div>
                  <div class="field">
                    <label for="name" class="label">Last name</label>
                    <input type="text" name="name" id="name" class="input" placeholder="Doe" value="<?= htmlspecialchars($usersInfos['last_name'] ?? ''); ?>" required />
                  </div>
                  <div class="field">
                    <label for="username" class="label">Username</label>
                    <input type="text" name="username" id="username" class="input" value="<?= htmlspecialchars($usersInfos['username'] ?? ''); ?>" readonly />
                  </div>
                  <div class="btn-group">
                    <input type="submit" name="validatePersonalInfo" class="btn btn--primary" value="Save" />
                    <input type="reset" class="btn btn--secondary" value="Reset" />
                  </div>
                </div>
              </div>
            </form>

            <form method="post">
              <?= csrf_field(); ?>
              <div class="card">
                <div class="card__body">
                  <h2 class="card__title">School information</h2>
                  <?php if (isset($errorMsg2)) { ?>
                    <div class="alert alert--warning" role="alert">
                      <svg class="icon"><use href="#i-alert"/></svg>
                      <div><?= $errorMsg2; ?></div>
                    </div>
                  <?php } ?>
                  <?php if (isset($_GET['msg2'])) { ?>
                    <div class="alert alert--success" role="alert">
                      <svg class="icon"><use href="#i-check"/></svg>
                      <div>Your changes have been saved.</div>
                    </div>
                  <?php } ?>
                  <div class="field">
                    <label for="class_name" class="label">Class</label>
                    <select name="class_name" id="class_name" class="select" required>
                      <?php include '../actions/functions/getClassesAndOptions.php'; ?>
                    </select>
                  </div>
                  <div class="btn-group">
                    <input type="submit" name="validateSchoolInfo" class="btn btn--primary" value="Save" />
                    <input type="reset" class="btn btn--secondary" value="Reset" />
                  </div>
                </div>
              </div>
            </form>

            <?php if ($_SESSION['grade'] == '1' or $_SESSION['grade'] == '2') { ?>

              <form method="post">
                <?= csrf_field(); ?>
                <div class="card">
                  <div class="card__body">
                    <h2 class="card__title">Grade</h2>
                    <?php if (isset($errorMsg5)) { ?>
                      <div class="alert alert--warning" role="alert">
                        <svg class="icon"><use href="#i-alert"/></svg>
                        <div><?= $errorMsg5; ?></div>
                      </div>
                    <?php } ?>
                    <?php if (isset($_GET['msg5'])) { ?>
                      <div class="alert alert--success" role="alert">
                        <svg class="icon"><use href="#i-check"/></svg>
                        <div>Your changes have been saved.</div>
                      </div>
                    <?php } ?>
                    <div class="field">
                      <label for="grade" class="label">Current grade: <?php if (isset($usersInfos['grade'])) { Grade($usersInfos['grade']); } ?></label>
                      <select class="select" name="grade" id="grade">
                        <option value="0" <?php Selected('0', $usersInfos['grade'] ?? ''); ?>>None</option>
                        <option value="3" <?php Selected('3', $usersInfos['grade'] ?? ''); ?>>Assistant</option>
                        <option value="2" <?php Selected('2', $usersInfos['grade'] ?? ''); ?>>Manager</option><?php if ($_SESSION['grade'] == '1') { ?><option value="1" <?php Selected('1', $usersInfos['grade'] ?? ''); ?>>Administrator</option><?php } ?>
                      </select>
                    </div>
                    <div class="btn-group">
                      <input type="submit" name="validateGrade" class="btn btn--primary" value="Save" />
                      <input type="reset" class="btn btn--secondary" value="Reset" />
                    </div>
                  </div>
                </div>
              </form>

              <form method="post">
                <?= csrf_field(); ?>
                <div class="card">
                  <div class="card__body">
                    <h2 class="card__title">Password</h2>
                    <?php if (isset($errorMsg3)) { ?>
                      <div class="alert alert--warning" role="alert">
                        <svg class="icon"><use href="#i-alert"/></svg>
                        <div><?= $errorMsg3; ?></div>
                      </div>
                    <?php } ?>
                    <?php if (isset($_GET['msg3'])) { ?>
                      <div class="alert alert--success" role="alert">
                        <svg class="icon"><use href="#i-check"/></svg>
                        <div>Your changes have been saved.</div>
                      </div>
                    <?php } ?>
                    <div class="field">
                      <label for="new-password" class="label">New password</label>
                      <input type="password" name="new-password" id="new-password" class="input" required />
                    </div>
                    <div class="field">
                      <label for="confirm-new-password" class="label">Confirm new password</label>
                      <input type="password" name="confirm-new-password" id="confirm-new-password" class="input" required />
                    </div>
                    <div class="btn-group">
                      <input type="submit" name="validatePassword" class="btn btn--primary" value="Save" />
                    </div>
                  </div>
                </div>
              </form>

              <form method="post">
                <?= csrf_field(); ?>
                <div class="card">
                  <div class="card__body">
                    <h2 class="card__title">Delete the account</h2>
                    <?php if (isset($errorMsg4)) { ?>
                      <div class="alert alert--warning" role="alert">
                        <svg class="icon"><use href="#i-alert"/></svg>
                        <div><?= $errorMsg4; ?></div>
                      </div>
                    <?php } ?>
                    <?php if (!isset($deleteAccount)) { ?>
                      <div class="btn-group">
                        <input type="submit" name="validateDelete1" class="btn btn--danger" value="Delete the account" />
                      </div>
                    <?php } elseif (isset($deleteAccount)) { ?>
                      <div class="alert alert--danger" role="alert">
                        <svg class="icon"><use href="#i-alert"/></svg>
                        <div>I confirm that I want to delete this account. This action is irreversible.</div>
                      </div>
                      <div class="btn-group">
                        <input type="submit" value="Delete" name="validateDelete2" class="btn btn--danger" />
                      </div>
                    <?php } ?>
                  </div>
                </div>
              </form>
            <?php }
    } ?>
          </div>
        </div>
      </main>
      <?php include '../includes/footer.php'; ?>
    </body>

    </html>
  <?php } else {
  http_response_code(403);
  require '../errors/403.php';
  exit;
} ?>
