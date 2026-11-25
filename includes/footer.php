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
        <p><?= bookfind_translate('The library of the C.D.I., simple and modern. Search, borrow and manage the books of your institution.'); ?></p>
      </div>

      <div class="footer__col">
        <div class="footer__title"><?= bookfind_translate('Navigation'); ?></div>
        <a class="footer__link" href="/index.php"><?= bookfind_translate('Home'); ?></a>
        <a class="footer__link" href="/books.php"><?= bookfind_translate('Search for a book'); ?></a>
        <a class="footer__link" href="/rules.php"><?= bookfind_translate('Rules'); ?></a>
        <a class="footer__link" href="/privacy.php"><?= bookfind_translate('Privacy policy'); ?></a>
      </div>

      <div class="footer__col">
        <div class="footer__title"><?= bookfind_translate('Account'); ?></div>
        <a class="footer__link" href="/login.php"><?= bookfind_translate('Sign in'); ?></a>
        <a class="footer__link" href="/signup.php"><?= bookfind_translate('Sign up'); ?></a>
        <div class="footer__social">
          <a href="https://github.com/Chromared" aria-label="GitHub" target="_blank" rel="noopener noreferrer">
            <svg class="icon"><use href="#i-github"/></svg>
          </a>
        </div>
      </div>
    </div>

    <div class="footer__bottom">© <?= date('Y'); ?> BookFind by Chromared</div>
  </div>
</footer>
<?php } ?>
