<?php
//This file belongs to the BookFind project.
//
//BookFind is distributed under the terms of the GNU Affero General Public License v3.0.
//
//Copyright (C) 2025 Chromared
?>

<?php if (isset($_GET['s']) AND !empty($_GET['s'])) {

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
            <svg class="icon"><use href="#i-search"/></svg>
            <p>No books found with these search criteria.</p>
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
                        <span class="book-card__status"><span class="badge badge--warning">Borrowed</span></span>
                    <?php } ?>
                    <svg class="icon"><use href="#i-book"/></svg>
                </div>
                <div class="book-card__body">
                    <div class="book-card__title"><?= htmlspecialchars($books['title']); ?></div>
                    <div class="book-card__author"><?= htmlspecialchars($books['author']); ?></div>
                    <div class="book-card__meta">
                        <?php if (!empty($books['type'])) { ?><span class="chip"><?= htmlspecialchars($books['type']); ?></span><?php } ?>
                        <?php if (!empty($books['genre'])) { ?><span class="chip"><?= htmlspecialchars($books['genre']); ?></span><?php } ?>
                        <?php if (!empty($books['series'])) { ?><span class="chip">Volume <?= htmlspecialchars($books['volume']); ?></span><?php } ?>
                    </div>
                    <?php if ($books['status'] == 1 && isset($_SESSION['auth']) AND $_SESSION['grade'] != 0) { ?>
                        <div class="book-card__author mt-2">
                            <?= _('By'); ?> <a href="../profile.php?id=<?= htmlspecialchars($loans['borrower_id']); ?>"><?= htmlspecialchars($loans['borrower_name']); ?></a> — <?= _('due'); ?> <?php ColorLoanDate($loans['due_date']); ?>
                        </div>
                    <?php } ?>
                    <div class="book-card__foot">
                        <a href="books-reader.php?id=<?= htmlspecialchars($books['id']); ?>" class="btn btn--secondary">View</a>
                        <?php if (isset($_SESSION['auth']) AND $_SESSION['grade'] != 0) { ?>
                            <a href="<?php if (!isset($gestion)) { ?>gestion/<?php } ?>loan.php?id=<?= htmlspecialchars($books['id']); ?><?php if ($books['status'] == 1) { echo '&user_id=' . htmlspecialchars($loans['borrower_id']); } ?>" class="btn btn--success">Loan</a>
                        <?php } ?>
                    </div>
                </div>
            </div>
        <?php } ?>
        </div>
    <?php }
}
