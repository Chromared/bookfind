<?php
//This file belongs to the BookFind project.
//
//BookFind is distributed under the terms of the GNU Affero General Public License v3.0.
//
//Copyright (C) 2025 Chromared
?>

<?php require_once __DIR__ . '/../../../actions/functions/sessionInit.php';
require_once __DIR__ . '/../../../actions/functions/gettextFunction.php';
require_once __DIR__ . '/../../../actions/users/securityAction.php';
include '../actions/functions/gradeIntToText.php';

if (isset($_GET['s']) AND !empty($_GET['s'])) {

    $s = $_GET['s'];
    $keywords = explode(' ', $s);
    $searchConditions = [];

    foreach ($keywords as $keyword) {
        $searchConditions[] = "(first_name LIKE ? OR last_name LIKE ? OR username LIKE ? OR class_name LIKE ? OR loans_count LIKE ? OR grade LIKE ?)";
    }

    $sql = 'SELECT * FROM users WHERE ' . implode(' AND ', $searchConditions) . '';
    $sUsers = $db->prepare($sql);
    $params = [];
    foreach ($keywords as $keyword) {
        $params = array_merge($params, array_fill(0, 6, "%$keyword%"));
    }
    $sUsers->execute($params);

    if ($sUsers->rowCount() == 0) { ?>
        <div class="empty">
            <svg class="icon"><use href="#i-people"/></svg>
            <p>No users found with these search criteria.</p>
        </div>
    <?php } else { ?>
        <div class="grid grid--auto">
        <?php
        while ($users = $sUsers->fetch()) { ?>
            <?php if ($users['loans_count'] == 1) { $loans = 'loan'; } else { $loans = 'loans'; }
            $initials = strtoupper(substr($users['first_name'] ?? '', 0, 1) . substr($users['last_name'] ?? '', 0, 1)); ?>
            <div class="card">
                <div class="card__body">
                    <div class="profile-head">
                        <span class="avatar" style="width:48px;height:48px;font-size:17px;"><?= htmlspecialchars($initials); ?></span>
                        <div>
                            <div class="book-card__title"><?= htmlspecialchars($users['first_name']); ?> <?= htmlspecialchars($users['last_name']); ?></div>
                            <div class="book-card__author">@<?= htmlspecialchars($users['username']); ?></div>
                        </div>
                    </div>
                    <div class="book-card__meta mt-3">
                        <span class="chip"><?php if (in_array($users['class_name'], ['None', 'Aucune'], true)) { ?><?= _('No class'); ?><?php } else { ?><?= htmlspecialchars($users['class_name']); ?><?php } ?></span>
                        <?php if ($users['loans_count'] > 0) { ?><span class="chip"><?= htmlspecialchars($users['loans_count']) . ' ' . $loans; ?></span><?php } ?>
                        <?php Grade($users['grade']); ?>
                    </div>
                    <div class="book-card__foot">
                        <?php if ($_SESSION['grade'] == '1' OR $_SESSION['grade'] == '2') { ?>
                            <a href="update-user.php?id=<?= $users['id'] ?>" class="btn btn--primary">Edit</a>
                        <?php } ?>
                        <a href="../profile.php?id=<?= $users['id'] ?>" class="btn btn--secondary">View</a>
                        <a href="user-loans.php?id=<?= htmlspecialchars($users['id']) ?>" class="btn btn--success">Loans</a>
                    </div>
                </div>
            </div>
        <?php } ?>
        </div>
    <?php }
}
