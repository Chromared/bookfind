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

<?php if (isset($_GET['s']) and !empty($_GET['s'])) {

    $s = $_GET['s'];
    $keywords = explode(' ', $s);
    $searchConditions = [];

    foreach ($keywords as $keyword) {
        $searchConditions[] = "(title LIKE ? OR author LIKE ? OR isbn LIKE ? OR publisher LIKE ? OR genre LIKE ? OR type LIKE ? OR series LIKE ? OR unique_id LIKE ?)";
    }

    $sql = 'SELECT * FROM books WHERE ' . implode(' AND ', $searchConditions) . ' ORDER BY title';
    $fetchedBooks = $db->prepare($sql);
    $params = [];
    foreach ($keywords as $keyword) {
        $params = array_merge($params, array_fill(0, 8, "%$keyword%"));
    }
    $fetchedBooks->execute($params);

    if ($fetchedBooks->rowCount() == 0) { ?>
        <div class="empty">
            <svg class="icon">
                <use href="#i-search" />
            </svg>
            <p><?= bookfind_translate('No books found with these search criteria.'); ?></p>
        </div>
    <?php } elseif ($fetchedBooks->rowCount() > 0) { ?>
        <div class="books-grid">
            <?php
            while ($books = $fetchedBooks->fetch()) {
                $fetchedLoans = $db->prepare('SELECT * FROM loans WHERE book_id = ? AND status = 1');
                $fetchedLoans->execute(array($books['id']));
                $loans = $fetchedLoans->fetch(); ?>
                <div class="book-card">
                    <div class="book-card__cover">
                        <?php if ($books['status'] == 1) { ?>
                            <span class="book-card__status"><span class="badge badge--warning"><?= bookfind_translate('Borrowed'); ?></span></span>
                        <?php } ?>
                        <svg class="icon">
                            <use href="#i-book" />
                        </svg>
                    </div>
                    <div class="book-card__body">
                        <div class="book-card__title"><?= htmlspecialchars($books['title']); ?></div>
                        <div class="book-card__author"><?= htmlspecialchars($books['author']); ?></div>
                        <div class="book-card__meta">
                            <?php if (!empty($books['type'])) { ?><span class="chip"><?= htmlspecialchars($books['type']); ?></span><?php } ?>
                            <?php if (!empty($books['genre'])) { ?><span class="chip"><?= htmlspecialchars($books['genre']); ?></span><?php } ?>
                            <?php if (!empty($books['series'])) { ?><span class="chip"><?= bookfind_translate('Volume'); ?> <?= htmlspecialchars($books['volume']); ?></span><?php } ?>
                        </div>
                        <?php if ($books['status'] == 1 && isset($_SESSION['auth']) and $_SESSION['grade'] != 0) { ?>
                            <div class="book-card__author mt-2">
                                <?php require_once ROOT_PATH . '/actions/functions/loanBorrowerFunction.php'; ?>
                                <?= bookfind_translate('By'); ?> <?= loanBorrowerHtml($loans); ?> — <?= bookfind_translate('due'); ?> <?php ColorLoanDate($loans['due_date']); ?>
                            </div>
                        <?php } ?>
                        <div class="book-card__foot">
                            <a href="<?= url((isset($gestion) && $gestion ? 'gestion/' : '') . 'books-reader.php?id=' . rawurlencode((string)$books['id'])); ?>" class="btn btn--secondary"><?= bookfind_translate('View'); ?></a>
                            <?php if (isset($_SESSION['auth']) and $_SESSION['grade'] != 0) { ?>
                                <a href="<?= url('gestion/loan.php?id=' . rawurlencode((string)$books['id']) . ($books['status'] == 1 ? '&user_id=' . rawurlencode((string)$loans['borrower_id']) : '')); ?>" class="btn btn--success"><?= bookfind_translate('Loan'); ?></a>
                            <?php } ?>
                        </div>
                    </div>
                </div>
            <?php } ?>
        </div>
<?php }
}
