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

<?php require 'actions/database.php';
require 'actions/users/securityAction.php';
require_once 'actions/functions/gettextFunction.php';
require 'actions/functions/logFunction.php';
if (isset($_GET['id']) and !empty($_GET['id'])) {
  require 'actions/users/showOneUserProfileAction.php';
} else {
  header('Location: profile.php?id=' . $_SESSION['id']);
}
require 'actions/functions/gradeIntToText.php';
require 'actions/functions/conversionDateHour.php'; ?>
<!DOCTYPE html>
<html lang="<?= $GLOBALS['bookfindLocale'] === 'fr_FR' ? 'fr' : 'en'; ?>" data-theme="<?php include 'actions/users/decodeThemeAction.php'; ?>">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title><?= bookfind_translate('BookFind — Profile'); ?></title>
  <?php include 'includes/header.php' ?>
</head>

<body>
  <?php include 'includes/navbar.php' ?>
  <main class="page">
    <div class="container">
      <?php if ($selectInfosFromUsers->rowCount() === 1) { ?>
        <?php
        $initials = strtoupper(substr($usersInfos['first_name'] ?? '', 0, 1) . substr($usersInfos['last_name'] ?? '', 0, 1)); ?>

        <div class="stack">
          <div class="card">
            <div class="card__body">
              <div class="profile-head">
                <span class="avatar"><?= htmlspecialchars($initials); ?></span>
                <div>
                  <h1 class="profile-head__name"><?= htmlspecialchars($usersInfos['first_name']); ?> <?= htmlspecialchars($usersInfos['last_name']); ?></h1>
                  <div class="profile-head__meta">
                    <span>@<?= htmlspecialchars($usersInfos['username']); ?></span>
                    <span class="badge badge--neutral"><?= bookfind_translate('ID no.'); ?> <?= htmlspecialchars($usersInfos['id']); ?></span>
                    <?php Grade($usersInfos['grade']); ?>
                  </div>
                </div>
                <div class="btn-group" style="margin-left:auto;">
                  <?php if ($usersInfos['id'] == $_SESSION['id']) { ?>
                    <a href="actions/users/logoutAction.php" class="btn btn--secondary"><?= bookfind_translate('Sign out'); ?></a>
                    <a href="updateProfile.php?id=<?= htmlspecialchars($_SESSION['id']); ?>" class="btn btn--primary"><?= bookfind_translate('Edit'); ?></a>
                  <?php } elseif ($_SESSION['grade'] != 0) { ?>
                    <a href="gestion/user-loans.php?id=<?= htmlspecialchars($usersInfos['username']) ?>" class="btn btn--success"><?= bookfind_translate('Loans'); ?></a>
                    <a href="gestion/update-user.php?id=<?= htmlspecialchars($usersInfos['id']) ?>" class="btn btn--primary"><?= bookfind_translate('Edit'); ?></a>
                  <?php } ?>
                </div>
              </div>
            </div>
          </div>

          <div class="grid grid--3">
            <div class="stat-strip__item">
              <div class="stat-strip__value"><?= htmlspecialchars($usersInfos['loans_count']); ?></div>
              <div class="stat-strip__label"><?= bookfind_translate($usersInfos['loans_count'] == 1 ? 'Ongoing loan' : 'Ongoing loans'); ?></div>
            </div>
            <div class="stat-strip__item">
              <div class="stat-strip__value"><?= htmlspecialchars($usersInfos['max_loans']); ?></div>
              <div class="stat-strip__label"><?= bookfind_translate('Maximum loans'); ?></div>
            </div>
            <div class="stat-strip__item">
              <div class="stat-strip__value" style="font-size:20px; line-height:1.2;"><?= htmlspecialchars(in_array($usersInfos['class_name'], ['None', 'Aucune'], true) ? bookfind_translate('No class') : $usersInfos['class_name'], ENT_QUOTES, 'UTF-8'); ?></div>
              <div class="stat-strip__label"><?= bookfind_translate('Class'); ?></div>
            </div>
          </div>

          <div class="card">
            <div class="card__header">
              <svg class="icon"><use href="#i-info"/></svg>
              <?= bookfind_translate('Information'); ?>
            </div>
            <div class="card__body">
              <div class="kv">
                <span class="kv__k"><?= bookfind_translate('Class'); ?></span>
                <span class="kv__v"><?php if (in_array($usersInfos['class_name'], ['None', 'Aucune'], true)) { ?><?= bookfind_translate('Not part of any class'); ?><?php } else { ?><?= htmlspecialchars($usersInfos['class_name']); ?><?php } ?></span>
              </div>
              <div class="kv">
                <span class="kv__k"><?= bookfind_translate('Ongoing loans'); ?></span>
                <span class="kv__v"><?= htmlspecialchars($usersInfos['loans_count']); ?> of <?= htmlspecialchars($usersInfos['max_loans']); ?></span>
              </div>
              <div class="kv">
                <span class="kv__k"><?= bookfind_translate('Registered on'); ?></span>
                <span class="kv__v"><?php ConversionDateHour($usersInfos['datetime']); ?></span>
              </div>
              <div class="kv">
                <span class="kv__k"><?= bookfind_translate('Grade'); ?></span>
                <span class="kv__v"><?php Grade($usersInfos['grade']); ?></span>
              </div>
            </div>
          </div>
        </div>
      <?php } else { ?>
        <div class="empty">
          <svg class="icon"><use href="#i-people"/></svg>
          <p><?= bookfind_translate('No user with ID'); ?> <?= htmlspecialchars($_GET['id']); ?> <?= bookfind_translate('was found.'); ?></p>
        </div>
      <?php } ?>
    </div>
  </main>
  <?php include 'includes/footer.php'; ?>
</body>

</html>
