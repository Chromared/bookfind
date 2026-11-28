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

<?php require_once ROOT_PATH . '/actions/functions/sessionInit.php';
require_once ROOT_PATH . '/actions/functions/gettextFunction.php';
require_once ROOT_PATH . '/actions/users/securityAction.php';
include ROOT_PATH . '/actions/functions/gradeIntToText.php';

if (isset($_GET['s']) and !empty($_GET['s'])) {

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
            <svg class="icon">
                <use href="#i-people" />
            </svg>
            <p><?= bookfind_translate('No users found with these search criteria.'); ?></p>
        </div>
    <?php } else { ?>
        <div class="grid grid--auto">
            <?php
            while ($users = $sUsers->fetch()) { ?>
                <?php $loans = $users['loans_count'] == 1 ? bookfind_translate('loan') : bookfind_translate('loans');
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
                            <span class="chip"><?php if (in_array($users['class_name'], ['None', 'Aucune'], true)) { ?><?= bookfind_translate('No class'); ?><?php } else { ?><?= htmlspecialchars($users['class_name']); ?><?php } ?></span>
                            <?php if ($users['loans_count'] > 0) { ?><span class="chip"><?= htmlspecialchars($users['loans_count']) . ' ' . $loans; ?></span><?php } ?>
                            <?php Grade($users['grade']); ?>
                        </div>
                        <div class="book-card__foot">
                            <?php if ($_SESSION['grade'] == '1' or $_SESSION['grade'] == '2') { ?>
                                <a href="<?= url('gestion/update-user.php?id=' . rawurlencode((string)$users['id'])); ?>" class="btn btn--primary"><?= bookfind_translate('Edit'); ?></a>
                            <?php } ?>
                            <a href="<?= url('profile.php?id=' . rawurlencode((string)$users['id'])); ?>" class="btn btn--secondary"><?= bookfind_translate('View'); ?></a>
                            <a href="<?= url('gestion/user-loans.php?id=' . rawurlencode((string)$users['id'])); ?>" class="btn btn--success"><?= bookfind_translate('Loans'); ?></a>
                        </div>
                    </div>
                </div>
            <?php } ?>
        </div>
<?php }
}
