<?php require_once dirname(__DIR__) . '/includes/paths.php'; require_once ROOT_PATH . '/actions/functions/sessionInit.php'; ?>
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

<?php if (isset($_GET['id']) and !empty($_GET['id'])) { ?>
  <?php require ROOT_PATH . '/actions/database.php';
  require ROOT_PATH . '/actions/users/securityAction.php';
  require ROOT_PATH . '/gestion/actions/users/securityAdminAction.php';
  require ROOT_PATH . '/actions/functions/logFunction.php';
  require ROOT_PATH . '/actions/users/showOneUserProfileAction.php';
  if (($_SESSION['grade'] != '1' and ($usersInfos['grade'] ?? null) == '1') or ($_SESSION['grade'] != '1' and $_SESSION['grade'] != '2' and ($usersInfos['grade'] ?? null) == '2') or $_SESSION['grade'] == '3') {
    http_response_code(403);
    require ROOT_PATH . '/errors/403.php';
    exit;
  } else {
    require ROOT_PATH . '/actions/functions/selected.php';
    require ROOT_PATH . '/actions/functions/gradeIntToText.php';
    require ROOT_PATH . '/gestion/actions/users/updatePersonalInfoAction.php';
    require ROOT_PATH . '/gestion/actions/users/updateSchoolInfoAction.php';
    require ROOT_PATH . '/gestion/actions/users/updateGradeAction.php';
    require ROOT_PATH . '/gestion/actions/users/updatePasswordAction.php';
    require ROOT_PATH . '/gestion/actions/users/deleteAccountAction1.php';
    require ROOT_PATH . '/gestion/actions/users/deleteAccountAction2.php'; ?>
    <!DOCTYPE html>
    <html lang="<?= $GLOBALS['bookfindLocale'] === 'fr_FR' ? 'fr' : 'en'; ?>" data-theme="<?php include ROOT_PATH . '/actions/users/decodeThemeAction.php'; ?>">

    <head>
      <meta charset="UTF-8">
      <meta name="viewport" content="width=device-width, initial-scale=1.0">
      <title><?= bookfind_translate('BookFind — Update user account'); ?></title>
      <?php include ROOT_PATH . '/includes/header.php' ?>
    </head>

    <body class="admin">
      <?php include ROOT_PATH . '/gestion/includes/navbar.php' ?>
      <main class="page">
        <div class="container">
          <div class="narrow stack">

            <form action="<?= url(ltrim(str_replace(BASE_URL, '', $_SERVER['SCRIPT_NAME']), '/')) . (!empty($_SERVER['QUERY_STRING']) ? '?' . htmlspecialchars($_SERVER['QUERY_STRING'], ENT_QUOTES, 'UTF-8') : ''); ?>" method="post">
              <?= csrf_field(); ?>
              <div class="card">
                <div class="card__body">
                  <h1 class="card__title"><?= bookfind_translate('Personal information'); ?></h1>
                  <?php if (isset($errorMsg1)) { ?>
                    <div class="alert alert--warning" role="alert">
                      <svg class="icon"><use href="#i-alert"/></svg>
                      <div><?= $errorMsg1; ?></div>
                    </div>
                  <?php } ?>
                  <?php if (isset($_GET['msg1'])) { ?>
                    <div class="alert alert--success" role="alert">
                      <svg class="icon"><use href="#i-check"/></svg>
                      <div><?= bookfind_translate('Your changes have been saved.'); ?></div>
                    </div>
                  <?php } ?>
                  <div class="field">
                    <label for="firstname" class="label"><?= bookfind_translate('First name'); ?></label>
                    <input type="text" name="firstname" id="firstname" class="input" placeholder="<?= bookfind_translate('First name'); ?>" value="<?= htmlspecialchars($usersInfos['first_name'] ?? ''); ?>" required />
                  </div>
                  <div class="field">
                    <label for="name" class="label"><?= bookfind_translate('Last name'); ?></label>
                    <input type="text" name="name" id="name" class="input" placeholder="<?= bookfind_translate('Last name'); ?>" value="<?= htmlspecialchars($usersInfos['last_name'] ?? ''); ?>" required />
                  </div>
                  <div class="field">
                    <label for="username" class="label"><?= bookfind_translate('Username'); ?></label>
                    <input type="text" name="username" id="username" class="input" value="<?= htmlspecialchars($usersInfos['username'] ?? ''); ?>" readonly />
                  </div>
                  <div class="btn-group">
                    <input type="submit" name="validatePersonalInfo" class="btn btn--primary" value="<?= bookfind_translate('Save'); ?>" />
                    <input type="reset" class="btn btn--secondary" value="<?= bookfind_translate('Reset'); ?>" />
                  </div>
                </div>
              </div>
            </form>

            <form action="<?= url(ltrim(str_replace(BASE_URL, '', $_SERVER['SCRIPT_NAME']), '/')) . (!empty($_SERVER['QUERY_STRING']) ? '?' . htmlspecialchars($_SERVER['QUERY_STRING'], ENT_QUOTES, 'UTF-8') : ''); ?>" method="post">
              <?= csrf_field(); ?>
              <div class="card">
                <div class="card__body">
                  <h2 class="card__title"><?= bookfind_translate('School information'); ?></h2>
                  <?php if (isset($errorMsg2)) { ?>
                    <div class="alert alert--warning" role="alert">
                      <svg class="icon"><use href="#i-alert"/></svg>
                      <div><?= $errorMsg2; ?></div>
                    </div>
                  <?php } ?>
                  <?php if (isset($_GET['msg2'])) { ?>
                    <div class="alert alert--success" role="alert">
                      <svg class="icon"><use href="#i-check"/></svg>
                      <div><?= bookfind_translate('Your changes have been saved.'); ?></div>
                    </div>
                  <?php } ?>
                  <div class="field">
                    <label for="class_name" class="label"><?= bookfind_translate('Class'); ?></label>
                    <select name="class_name" id="class_name" class="select" required>
                      <?php include ROOT_PATH . '/actions/functions/getClassesAndOptions.php'; ?>
                    </select>
                  </div>
                  <div class="btn-group">
                    <input type="submit" name="validateSchoolInfo" class="btn btn--primary" value="<?= bookfind_translate('Save'); ?>" />
                    <input type="reset" class="btn btn--secondary" value="<?= bookfind_translate('Reset'); ?>" />
                  </div>
                </div>
              </div>
            </form>

            <?php if ($_SESSION['grade'] == '1' or $_SESSION['grade'] == '2') { ?>

              <form action="<?= url(ltrim(str_replace(BASE_URL, '', $_SERVER['SCRIPT_NAME']), '/')) . (!empty($_SERVER['QUERY_STRING']) ? '?' . htmlspecialchars($_SERVER['QUERY_STRING'], ENT_QUOTES, 'UTF-8') : ''); ?>" method="post">
                <?= csrf_field(); ?>
                <div class="card">
                  <div class="card__body">
                    <h2 class="card__title"><?= bookfind_translate('Grade'); ?></h2>
                    <?php if (isset($errorMsg5)) { ?>
                      <div class="alert alert--warning" role="alert">
                        <svg class="icon"><use href="#i-alert"/></svg>
                        <div><?= $errorMsg5; ?></div>
                      </div>
                    <?php } ?>
                    <?php if (isset($_GET['msg5'])) { ?>
                      <div class="alert alert--success" role="alert">
                        <svg class="icon"><use href="#i-check"/></svg>
                        <div><?= bookfind_translate('Your changes have been saved.'); ?></div>
                      </div>
                    <?php } ?>
                    <div class="field">
                      <label for="grade" class="label"><?= bookfind_translate('Current grade:'); ?> <?php if (isset($usersInfos['grade'])) { Grade($usersInfos['grade']); } ?></label>
                      <select class="select" name="grade" id="grade">
                        <option value="0" <?php Selected('0', $usersInfos['grade'] ?? ''); ?>><?= bookfind_translate('None'); ?></option>
                        <option value="3" <?php Selected('3', $usersInfos['grade'] ?? ''); ?>><?= bookfind_translate('Assistant'); ?></option>
                        <option value="2" <?php Selected('2', $usersInfos['grade'] ?? ''); ?>><?= bookfind_translate('Manager'); ?></option><?php if ($_SESSION['grade'] == '1') { ?><option value="1" <?php Selected('1', $usersInfos['grade'] ?? ''); ?>><?= bookfind_translate('Administrator'); ?></option><?php } ?>
                      </select>
                    </div>
                    <div class="btn-group">
                      <input type="submit" name="validateGrade" class="btn btn--primary" value="<?= bookfind_translate('Save'); ?>" />
                      <input type="reset" class="btn btn--secondary" value="<?= bookfind_translate('Reset'); ?>" />
                    </div>
                  </div>
                </div>
              </form>

              <form action="<?= url(ltrim(str_replace(BASE_URL, '', $_SERVER['SCRIPT_NAME']), '/')) . (!empty($_SERVER['QUERY_STRING']) ? '?' . htmlspecialchars($_SERVER['QUERY_STRING'], ENT_QUOTES, 'UTF-8') : ''); ?>" method="post">
                <?= csrf_field(); ?>
                <div class="card">
                  <div class="card__body">
                    <h2 class="card__title"><?= bookfind_translate('Password'); ?></h2>
                    <?php if (isset($errorMsg3)) { ?>
                      <div class="alert alert--warning" role="alert">
                        <svg class="icon"><use href="#i-alert"/></svg>
                        <div><?= $errorMsg3; ?></div>
                      </div>
                    <?php } ?>
                    <?php if (isset($_GET['msg3'])) { ?>
                      <div class="alert alert--success" role="alert">
                        <svg class="icon"><use href="#i-check"/></svg>
                        <div><?= bookfind_translate('Your changes have been saved.'); ?></div>
                      </div>
                    <?php } ?>
                    <div class="field">
                      <label for="new-password" class="label"><?= bookfind_translate('New password'); ?></label>
                      <input type="password" name="new-password" id="new-password" class="input" required />
                    </div>
                    <div class="field">
                      <label for="confirm-new-password" class="label"><?= bookfind_translate('Confirm new password'); ?></label>
                      <input type="password" name="confirm-new-password" id="confirm-new-password" class="input" required />
                    </div>
                    <div class="btn-group">
                      <input type="submit" name="validatePassword" class="btn btn--primary" value="<?= bookfind_translate('Save'); ?>" />
                    </div>
                  </div>
                </div>
              </form>

              <form action="<?= url(ltrim(str_replace(BASE_URL, '', $_SERVER['SCRIPT_NAME']), '/')) . (!empty($_SERVER['QUERY_STRING']) ? '?' . htmlspecialchars($_SERVER['QUERY_STRING'], ENT_QUOTES, 'UTF-8') : ''); ?>" method="post">
                <?= csrf_field(); ?>
                <div class="card">
                  <div class="card__body">
                    <h2 class="card__title"><?= bookfind_translate('Delete the account'); ?></h2>
                    <?php if (isset($errorMsg4)) { ?>
                      <div class="alert alert--warning" role="alert">
                        <svg class="icon"><use href="#i-alert"/></svg>
                        <div><?= $errorMsg4; ?></div>
                      </div>
                    <?php } ?>
                    <?php if (!isset($deleteAccount)) { ?>
                      <div class="btn-group">
                        <input type="submit" name="validateDelete1" class="btn btn--danger" value="<?= bookfind_translate('Delete the account'); ?>" />
                      </div>
                    <?php } elseif (isset($deleteAccount)) { ?>
                      <div class="alert alert--danger" role="alert">
                        <svg class="icon"><use href="#i-alert"/></svg>
                        <div><?= bookfind_translate('I confirm that I want to delete this account. This action is irreversible.'); ?></div>
                      </div>
                      <div class="btn-group">
                        <input type="submit" value="<?= bookfind_translate('Delete'); ?>" name="validateDelete2" class="btn btn--danger" />
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
      <?php include ROOT_PATH . '/includes/footer.php'; ?>
    </body>

    </html>
  <?php } else {
  http_response_code(403);
  require ROOT_PATH . '/errors/403.php';
  exit;
} ?>
