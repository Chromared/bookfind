<?php
//This file belongs to the BookFind project.
//
//BookFind is distributed under the terms of the GNU Affero General Public License v3.0.
//
//Copyright (C) 2025 Chromared
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
<html lang="en" data-theme="<?php include 'actions/users/decodeThemeAction.php'; ?>">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>BookFind — Profile</title>
  <?php include 'includes/header.php' ?>
</head>

<body>
  <?php include 'includes/navbar.php' ?>
  <main class="page">
    <div class="container">
      <?php if ($selectInfosFromUsers->rowCount() === 1) { ?>
        <?php if ($usersInfos['loans_count'] == 1) {
          $loans = 'loan';
        } else {
          $loans = 'loans';
        }
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
                    <span class="badge badge--neutral">ID no. <?= htmlspecialchars($usersInfos['id']); ?></span>
                    <?php Grade($usersInfos['grade']); ?>
                  </div>
                </div>
                <div class="btn-group" style="margin-left:auto;">
                  <?php if ($usersInfos['id'] == $_SESSION['id']) { ?>
                    <a href="actions/users/logoutAction.php" class="btn btn--secondary">Sign out</a>
                    <a href="updateProfile.php?id=<?= htmlspecialchars($_SESSION['id']); ?>" class="btn btn--primary">Edit</a>
                  <?php } elseif ($_SESSION['grade'] != 0) { ?>
                    <a href="gestion/user-loans.php?id=<?= htmlspecialchars($usersInfos['username']) ?>" class="btn btn--success">Loans</a>
                    <a href="gestion/update-user.php?id=<?= htmlspecialchars($usersInfos['id']) ?>" class="btn btn--primary">Edit</a>
                  <?php } ?>
                </div>
              </div>
            </div>
          </div>

          <div class="grid grid--3">
            <div class="stat-strip__item">
              <div class="stat-strip__value"><?= htmlspecialchars($usersInfos['loans_count']); ?></div>
              <div class="stat-strip__label"><?= $loans; ?> ongoing</div>
            </div>
            <div class="stat-strip__item">
              <div class="stat-strip__value"><?= htmlspecialchars($usersInfos['max_loans']); ?></div>
              <div class="stat-strip__label">loans maximum</div>
            </div>
            <div class="stat-strip__item">
              <div class="stat-strip__value" style="font-size:20px; line-height:1.2;"><?= htmlspecialchars(in_array($usersInfos['class_name'], ['None', 'Aucune'], true) ? _('No class') : $usersInfos['class_name'], ENT_QUOTES, 'UTF-8'); ?></div>
              <div class="stat-strip__label">Class</div>
            </div>
          </div>

          <div class="card">
            <div class="card__header">
              <svg class="icon"><use href="#i-info"/></svg>
              Information
            </div>
            <div class="card__body">
              <div class="kv">
                <span class="kv__k">Class</span>
                <span class="kv__v"><?php if (in_array($usersInfos['class_name'], ['None', 'Aucune'], true)) { ?><?= _('Not part of any class'); ?><?php } else { ?><?= htmlspecialchars($usersInfos['class_name']); ?><?php } ?></span>
              </div>
              <div class="kv">
                <span class="kv__k">Ongoing loans</span>
                <span class="kv__v"><?= htmlspecialchars($usersInfos['loans_count']); ?> of <?= htmlspecialchars($usersInfos['max_loans']); ?></span>
              </div>
              <div class="kv">
                <span class="kv__k">Registered on</span>
                <span class="kv__v"><?php ConversionDateHour($usersInfos['datetime']); ?></span>
              </div>
              <div class="kv">
                <span class="kv__k">Grade</span>
                <span class="kv__v"><?php Grade($usersInfos['grade']); ?></span>
              </div>
            </div>
          </div>
        </div>
      <?php } else { ?>
        <div class="empty">
          <svg class="icon"><use href="#i-people"/></svg>
          <p>No user with id no. <?= htmlspecialchars($_GET['id']); ?> was found.</p>
        </div>
      <?php } ?>
    </div>
  </main>
  <?php include 'includes/footer.php'; ?>
</body>

</html>
