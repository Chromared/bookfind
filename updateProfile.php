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
  if ($_GET['id'] == $_SESSION['id']) {
    require 'actions/users/showOneUserProfileAction.php';
    require 'actions/functions/selected.php';
    require 'actions/users/updatePersonalInfoAction.php';
    require 'actions/users/updateSchoolInfoAction.php';
    require 'actions/users/updatePasswordAction.php';
    require 'actions/users/deleteAccountAction1.php';
    require 'actions/users/deleteAccountAction2.php'; ?>
    <!DOCTYPE html>
    <html lang="en" data-theme="<?php include 'actions/users/decodeThemeAction.php'; ?>">

    <head>
      <meta charset="UTF-8">
      <meta name="viewport" content="width=device-width, initial-scale=1.0">
      <title>BookFind — Update account</title>
      <?php include 'includes/header.php' ?>
    </head>

    <body>
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
                    <input type="text" name="firstname" id="firstname" class="input" placeholder="John" value="<?= htmlspecialchars($usersInfos['first_name']); ?>" required />
                  </div>
                  <div class="field">
                    <label for="name" class="label">Last name</label>
                    <input type="text" name="name" id="name" class="input" placeholder="Doe" value="<?= htmlspecialchars($usersInfos['last_name']); ?>" required />
                  </div>
                  <div class="field">
                    <label for="username" class="label">Username</label>
                    <input type="text" name="username" id="username" class="input" value="<?= htmlspecialchars($usersInfos['username']); ?>" readonly />
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
                      <?php include 'actions/functions/getClassesAndOptions.php'; ?>
                    </select>
                  </div>
                  <div class="btn-group">
                    <input type="submit" name="validateSchoolInfo" class="btn btn--primary" value="Save" />
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
                    <label for="actual-password" class="label">Current password</label>
                    <input type="password" name="actual-password" id="actual-password" class="input" required />
                  </div>
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
                    <div class="field">
                      <label for="password" class="label">Password</label>
                      <input type="password" name="password" id="password" class="input" required />
                    </div>
                    <div class="btn-group">
                      <input type="submit" name="validateDelete1" class="btn btn--danger" value="Delete the account" />
                    </div>
                  <?php } elseif (isset($deleteAccount)) { ?>
                    <div class="alert alert--danger" role="alert">
                      <svg class="icon"><use href="#i-alert"/></svg>
                      <div>I confirm that I want to delete my account. This action is irreversible.</div>
                    </div>
                    <div class="btn-group">
                      <input type="submit" value="Delete" name="validateDelete2" class="btn btn--danger" />
                    </div>
                  <?php } ?>
                </div>
              </div>
            </form>

          </div>
        </div>
      </main>
      <?php include 'includes/footer.php'; ?>
    </body>

    </html>
<?php } elseif ($_SESSION['grade'] !== 0) {
    header('Location: gestion/update-user.php?id=' . $_GET['id']);
  }
} ?>
