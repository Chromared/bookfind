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

<?php require 'actions/functions/sessionInit.php';

// Landing page statistics (live data, graceful fallback if the database is unavailable)
$landingStats = ['books' => 0, 'available' => 0, 'loans' => 0, 'readers' => 0, 'popular' => []];
try {
    require 'actions/database.php';

    $landingStats['books'] = (int)$db->query('SELECT COUNT(*) FROM books')->fetchColumn();
    $landingStats['available'] = (int)$db->query('SELECT COUNT(*) FROM books WHERE status = 0')->fetchColumn();
    $landingStats['loans'] = (int)$db->query('SELECT COUNT(*) FROM loans')->fetchColumn();
    $landingStats['readers'] = (int)$db->query('SELECT COUNT(DISTINCT borrower_id) FROM loans')->fetchColumn();
    $landingStats['popular'] = $db->query(
        'SELECT b.id, b.title, b.author, b.type, b.genre, b.series, b.volume, b.status, COUNT(l.id) AS nb_loans
         FROM books b
         LEFT JOIN loans l ON l.book_id = b.id
         GROUP BY b.id, b.title, b.author, b.type, b.genre, b.series, b.volume, b.status
         ORDER BY nb_loans DESC, b.title
         LIMIT 4'
    )->fetchAll(PDO::FETCH_ASSOC);
} catch (Exception $e) {
    $landingStats = ['books' => 0, 'available' => 0, 'loans' => 0, 'readers' => 0, 'popular' => []];
}

// Shorten a book title for the hero chips
function shortTitle($title, $max = 16) {
    return mb_strlen($title) > $max ? mb_substr($title, 0, $max - 1) . '…' : $title;
} ?>
<!DOCTYPE html>
<html lang="<?= $GLOBALS['bookfindLocale'] === 'fr_FR' ? 'fr' : 'en'; ?>" data-theme="<?php include 'actions/users/decodeThemeAction.php'; ?>">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title><?= bookfind_translate('BookFind — Library of the C.D.I.'); ?></title>
  <?php include 'includes/header.php'; ?>
</head>

<body>
  <noscript><style>.reveal { opacity: 1; transform: none; }</style></noscript>
  <?php include 'includes/navbar.php'; ?>
  <main class="page">
    <div class="container">
      <section class="hero">
        <div class="hero__content">
          <h1 class="hero__title"><?= bookfind_translate('All the C.D.I. books'); ?><br><span class="hero__accent"><?= bookfind_translate('within reach'); ?></span> <?= bookfind_translate('of your search.'); ?></h1>
          <?php if (!empty($landingStats['popular'])) { ?>
            <div class="hero__popular">
              <span class="hero__popular-label"><?= bookfind_translate('Popular right now'); ?></span>
              <span class="hero__popular-list">
                <?php foreach ($landingStats['popular'] as $i => $book) { ?>
                  <a class="chip chip--link" href="books.php?s=<?= urlencode($book['title']); ?>"><?= htmlspecialchars(shortTitle($book['title'], 22)); ?></a>
                <?php } ?>
              </span>
            </div>
          <?php } ?>
        </div>
      </section>

      <section class="landing-stats reveal" aria-label="<?= bookfind_translate('Library statistics'); ?>">
        <div class="landing-stat reveal">
          <span class="landing-stat__icon"><svg class="icon"><use href="#i-book"/></svg></span>
          <span class="landing-stat__value"><?= number_format($landingStats['books']); ?></span>
          <span class="landing-stat__label"><?= bookfind_translate('Books in the catalog'); ?></span>
        </div>
        <div class="landing-stat reveal">
          <span class="landing-stat__icon"><svg class="icon"><use href="#i-check"/></svg></span>
          <span class="landing-stat__value"><?= number_format($landingStats['available']); ?></span>
          <span class="landing-stat__label"><?= bookfind_translate('Available right now'); ?></span>
        </div>
        <div class="landing-stat reveal">
          <span class="landing-stat__icon"><svg class="icon"><use href="#i-arrow-up"/></svg></span>
          <span class="landing-stat__value"><?= number_format($landingStats['loans']); ?></span>
          <span class="landing-stat__label"><?= bookfind_translate('Loans recorded'); ?></span>
        </div>
        <div class="landing-stat reveal">
          <span class="landing-stat__icon"><svg class="icon"><use href="#i-people"/></svg></span>
          <span class="landing-stat__value"><?= number_format($landingStats['readers']); ?></span>
          <span class="landing-stat__label"><?= bookfind_translate('Active readers'); ?></span>
        </div>
      </section>

      <?php if (!empty($landingStats['popular'])) { ?>
        <section class="featured reveal" aria-label="<?= bookfind_translate('Featured books'); ?>">
          <div class="section-head">
            <h2><?= bookfind_translate('Featured books'); ?></h2>
            <p><?= bookfind_translate('Most borrowed books in the C.D.I. right now.'); ?></p>
          </div>
          <div class="books-grid">
            <?php foreach ($landingStats['popular'] as $book) { ?>
              <article class="book-card">
                <div class="book-card__cover">
                  <?php if ($book['status'] == 1) { ?>
                    <span class="book-card__status"><span class="badge badge--warning"><?= bookfind_translate('Borrowed'); ?></span></span>
                  <?php } ?>
                  <svg class="icon"><use href="#i-book"/></svg>
                </div>
                <div class="book-card__body">
                  <div class="book-card__title"><?= htmlspecialchars($book['title']); ?></div>
                  <div class="book-card__author"><?= htmlspecialchars($book['author']); ?></div>
                  <div class="book-card__meta">
                    <?php if (!empty($book['type'])) { ?><span class="chip"><?= htmlspecialchars($book['type']); ?></span><?php } ?>
                    <?php if (!empty($book['genre'])) { ?><span class="chip"><?= htmlspecialchars($book['genre']); ?></span><?php } ?>
                    <?php if (!empty($book['series'])) { ?><span class="chip"><?= bookfind_translate('Volume'); ?> <?= htmlspecialchars($book['volume']); ?></span><?php } ?>
                  </div>
                  <div class="book-card__foot">
                    <a href="books-reader.php?id=<?= (int)$book['id']; ?>" class="btn btn--secondary"><?= bookfind_translate('View'); ?></a>
                  </div>
                </div>
              </article>
            <?php } ?>
          </div>
        </section>
      <?php } ?>

      <section class="steps reveal">
        <div class="section-head">
          <h2><?= bookfind_translate('How does it work?'); ?></h2>
          <p><?= bookfind_translate('Three steps to get the most out of the library.'); ?></p>
        </div>
        <div class="grid grid--3">
          <div class="step reveal">
            <div class="step__head">
              <span class="step__icon"><svg class="icon"><use href="#i-search"/></svg></span>
              <span class="step__num">1</span>
            </div>
            <h3><?= bookfind_translate('Search'); ?></h3>
            <p><?= bookfind_translate("Find the book you're looking for across the entire C.D.I. catalog."); ?></p>
          </div>
          <div class="step reveal">
            <div class="step__head">
              <span class="step__icon"><svg class="icon"><use href="#i-book"/></svg></span>
              <span class="step__num">2</span>
            </div>
            <h3><?= bookfind_translate('Borrow'); ?></h3>
            <p><?= bookfind_translate('A manager records your loan in a few seconds.'); ?></p>
          </div>
          <div class="step reveal">
            <div class="step__head">
              <span class="step__icon"><svg class="icon"><use href="#i-arrow-up"/></svg></span>
              <span class="step__num">3</span>
            </div>
            <h3><?= bookfind_translate('Track'); ?></h3>
            <p><?= bookfind_translate('Find your due dates and returns from your profile.'); ?></p>
          </div>
        </div>
      </section>

      <?php if (!isset($_SESSION['auth'])) { ?>
        <section class="cta reveal">
          <div class="cta__inner">
            <h2><?= bookfind_translate('Ready to explore the catalog?'); ?></h2>
            <p><?= bookfind_translate('Create an account to borrow and track your books.'); ?></p>
            <div class="btn-group">
              <a href="signup.php" class="btn btn--primary btn--lg"><?= bookfind_translate('Sign up'); ?></a>
              <a href="login.php" class="btn btn--secondary btn--lg"><?= bookfind_translate('Sign in'); ?></a>
            </div>
          </div>
        </section>
      <?php } ?>
    </div>
  </main>

  <?php if (isset($_GET['signup']) and isset($_SESSION['auth'])) { ?>
    <div class="modal" id="successModal">
      <div class="modal__backdrop">
        <div class="modal__dialog" role="dialog" aria-modal="true" aria-labelledby="successModalLabel">
          <div class="modal__header">
            <h2 class="modal__title" id="successModalLabel"><?= bookfind_translate('Signup successful'); ?></h2>
            <button type="button" class="modal__close" data-modal-close aria-label="<?= bookfind_translate('Close'); ?>">
              <svg class="icon"><use href="#i-x"/></svg>
            </button>
          </div>
          <div class="modal__body">
            <?= bookfind_translate('Your account has been created successfully. To sign in, you will need your username, which is the following:'); ?> <strong><?= htmlspecialchars($_SESSION['username']); ?></strong>.
          </div>
          <div class="modal__footer">
            <button type="button" class="btn btn--success" data-modal-close><?= bookfind_translate('OK'); ?></button>
          </div>
        </div>
      </div>
    </div>
    <script nonce="<?= htmlspecialchars($_SESSION['csp_nonce'] ?? '') ?>">
      document.addEventListener("DOMContentLoaded", function() {
        var modal = document.getElementById('successModal');
        modal.classList.add('is-open');
        document.body.classList.add('modal-open');
      });
    </script>
  <?php } ?>
  <script nonce="<?= htmlspecialchars($_SESSION['csp_nonce'] ?? '') ?>">
    // Scroll reveal — sections fade up gently as they enter the viewport
    document.addEventListener("DOMContentLoaded", function() {
      var els = document.querySelectorAll('.reveal');
      if (!('IntersectionObserver' in window)) {
        for (var i = 0; i < els.length; i++) { els[i].classList.add('is-visible'); }
        return;
      }
      var io = new IntersectionObserver(function(entries) {
        for (var i = 0; i < entries.length; i++) {
          if (entries[i].isIntersecting) {
            entries[i].target.classList.add('is-visible');
            io.unobserve(entries[i].target);
          }
        }
      }, { threshold: 0.12 });
      for (var j = 0; j < els.length; j++) { io.observe(els[j]); }
    });
  </script>
  <?php include 'includes/footer.php'; ?>
</body>

</html>
