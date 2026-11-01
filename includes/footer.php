<?php
//This file belongs to the BookFind project.
//
//BookFind is distributed under the terms of the GNU Affero General Public License v3.0.
//
//Copyright (C) 2025 Chromared
?>

<?php include __DIR__ . '/icons.php'; ?>

<?php
// Footer shown on the homepage for every visitor (root or /bookfind/ install).
$footerScript = basename($_SERVER['SCRIPT_NAME'] ?? '');
$showFooter = ($footerScript === 'index.php' OR $footerScript === 'rules.php' OR $footerScript === 'privacy.php');
?>

<?php if ($showFooter) { ?>
<footer class="footer">
  <div class="footer__inner">
    <div class="footer__grid">
      <div class="footer__col">
        <a class="footer__logo" href="/index.php">
          <img src="/assets/logo.svg" alt="BookFind">
          <span>BookFind</span>
        </a>
        <p>The library of the C.D.I., simple and modern. Search, borrow and manage the books of your institution.</p>
      </div>

      <div class="footer__col">
        <div class="footer__title">Navigation</div>
        <a class="footer__link" href="/index.php">Home</a>
        <a class="footer__link" href="/books.php">Search for a book</a>
        <a class="footer__link" href="/rules.php">Rules</a>
        <a class="footer__link" href="/privacy.php">Privacy policy</a>
      </div>

      <div class="footer__col">
        <div class="footer__title">Account</div>
        <a class="footer__link" href="/login.php">Sign in</a>
        <a class="footer__link" href="/signup.php">Sign up</a>
        <div class="footer__social">
          <a href="https://github.com/Chromared" aria-label="GitHub" target="_blank" rel="noopener noreferrer">
            <svg class="icon"><use href="#i-github"/></svg>
          </a>
        </div>
      </div>
    </div>

    <div class="footer__bottom">© 2026 BookFind by Chromared</div>
  </div>
</footer>
<?php } ?>
