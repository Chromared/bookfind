<?php
//This file belongs to the BookFind project.
//
//BookFind is distributed under the terms of the GNU Affero General Public License v3.0.
//
//Copyright (C) 2025 Chromared
?>

<?php
require 'actions/functions/sessionInit.php';
require_once 'actions/database.php';
?>
<!DOCTYPE html>
<html lang="en" data-theme="<?php include 'actions/users/decodeThemeAction.php'; ?>">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>BookFind — Project configuration</title>
    <?php include 'includes/header.php'; ?>
</head>

<body>
    <?php include 'includes/navbar.php'; ?>

    <main class="page">
      <div class="container">
        <div class="narrow stack">
          <div class="center">
            <h1>Welcome to BookFind!</h1>
            <h2 class="text-subtle" style="font-size:1rem;font-weight:500;">Site configuration file</h2>
            <div class="alert alert--warning center" role="alert">
                <svg class="icon"><use href="#i-alert"/></svg>
                <div>Follow the steps in order. Some will disappear once completed.</div>
            </div>
          </div>

          <!-- Step 1: Database access -->
          <?php if (empty($host) && empty($dbname) && empty($username)) { ?>
              <div class="card">
                  <div class="card__header">1. Configure MySQL access</div>
                  <div class="card__body">
                      <form method="post">
                          <?= csrf_field(); ?>
                          <div class="field">
                              <label for="host" class="label">Host</label>
                              <input type="text" class="input" id="host" name="host" required>
                          </div>
                          <div class="field">
                              <label for="username" class="label">Username</label>
                              <input type="text" class="input" id="username" name="username" required>
                          </div>
                          <div class="field">
                              <label for="password" class="label">Password</label>
                              <input type="password" class="input" id="password" name="password">
                          </div>
                          <button type="submit" class="btn btn--primary btn--block">
                              <svg class="icon"><use href="#i-save"/></svg>Save
                          </button>
                      </form>
                      <?php
                      if (isset($_POST['host'], $_POST['username'], $_POST['password']) && !empty($_POST['host']) && !empty($_POST['username'])) {
                          $host = trim($_POST['host']);
                          $username = trim($_POST['username']);
                          $password = $_POST['password'];
                          $filePath = 'actions/database.php';
                          $fileContent = file_get_contents($filePath);

                          // Write safe PHP values using var_export via callback
                          $fileContent = preg_replace_callback('/\$host\s*=\s*\'[^\']*\';/', function($m) use ($host) {
                              return '$host = ' . var_export($host, true) . ';';
                          }, $fileContent);
                          $fileContent = preg_replace_callback('/\$username\s*=\s*\'[^\']*\';/', function($m) use ($username) {
                              return '$username = ' . var_export($username, true) . ';';
                          }, $fileContent);
                          $fileContent = preg_replace_callback('/\$password\s*=\s*\'[^\']*\';/', function($m) use ($password) {
                              return '$password = ' . var_export($password, true) . ';';
                          }, $fileContent);

                          file_put_contents($filePath, $fileContent);
                          if (function_exists('opcache_invalidate')) { opcache_invalidate($filePath, true); }
                          echo '<div class="alert alert--success mt-3"><svg class="icon"><use href="#i-check"/></svg><div>Saved successfully! <a href="configuration.php">Reload the page</a>.</div></div>';
                      }
                      ?>
                  </div>
              </div>
          <?php } else {
              echo '<div class="alert alert--success"><svg class="icon"><use href="#i-check"/></svg><div>Step 1 completed.</div></div>';
              $step1 = true;
          } ?>

          <!-- Step 2: Import database -->
          <?php if (empty($dbname)) { ?>
              <div class="card">
                  <div class="card__header">2. Import the database</div>
                  <div class="card__body">
                      <form method="post" class="mb-3">
                          <?= csrf_field(); ?>
                          <div class="mb-2">
                              <button type="submit" name="import" class="btn btn--primary btn--block">
                                  <svg class="icon"><use href="#i-db"/></svg>Import the database (create + tables)
                              </button>
                          </div>
                          <label class="check mb-3">
                              <input type="checkbox" value="1" id="onlyTables" name="onlyTables">
                              The database already exists — import tables only
                          </label>
                          <div class="input-group">
                              <input type="text" name="dbname_import" class="input" placeholder="Database name (optional, default 'bookfind')">
                              <button type="submit" name="import" class="btn btn--secondary">Import</button>
                          </div>
                      </form>
                      <form method="post">
                          <?= csrf_field(); ?>
                          <div class="input-group">
                              <input type="text" name="dbname" class="input" placeholder="Database name" required>
                              <button type="submit" name="alreadyImport" class="btn btn--secondary">I have already imported the database</button>
                          </div>
                      </form>
                      <?php
                      if (isset($_POST['dbname'], $_POST['alreadyImport']) && !empty($_POST['dbname'])) {
                          if (!empty($host) && !empty($username)) {
                              $dbname = $_POST['dbname'];
                              $filePath = 'actions/database.php';
                              $fileContent = file_get_contents($filePath);
                              $fileContent = preg_replace_callback('/\$dbname\s*=\s*\'[^\']*\';/', function ($m) use ($dbname) {
                                  return '$dbname = ' . var_export($dbname, true) . ';';
                              }, $fileContent);
                              file_put_contents($filePath, $fileContent);
                              try {
                                  $db = new PDO('mysql:host=' . $host . ';dbname=' . $dbname . ';charset=utf8', $username, $password);
                                  $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
                              } catch (PDOException $e) {
                                  $db = null;
                                  echo '<div class="alert alert--danger mt-3">Cannot connect to database "' . htmlspecialchars($dbname) . '": ' . htmlspecialchars($e->getMessage()) . '</div>';
                              }
                              $sqlFilePath = 'actions/bookfind.sql';
                              if (file_exists($sqlFilePath) && isset($db) && $db !== null) {
                                  $sql = file_get_contents($sqlFilePath);
                                  $sql = preg_replace('/CREATE DATABASE\s+IF NOT EXISTS.*?;|CREATE DATABASE.*?;|USE `.*?`;/is', '', $sql);
                                  $queries = array_filter(array_map('trim', explode(';', $sql)));
                                  foreach ($queries as $query) {
                                      if (!empty($query)) {
                                          try {
                                              $db->exec($query);
                                          } catch (Exception $e) {
                                              echo '<div class="alert alert--danger">SQL execution error: ' . htmlspecialchars($e->getMessage()) . '</div>';
                                          }
                                      }
                                  }
                                  echo '<div class="alert alert--success mt-3">Tables imported. <a href="configuration.php">Reload the page</a>.</div>';
                              } elseif (!file_exists($sqlFilePath)) {
                                  echo '<div class="alert alert--warning mt-3">SQL file not found.</div>';
                              } else {
                                  echo '<div class="alert alert--danger mt-3">Cannot connect to database "' . htmlspecialchars($dbname) . '". Check your MySQL credentials and that the server is running.</div>';
                              }
                          } else {
                              echo '<div class="alert alert--danger mt-3">Missing MySQL credentials. Fill in the form above first.</div>';
                          }
                      }

                      if (isset($_POST['import'])) {
                          if (!empty($host) && !empty($username)) {
                              // If the user requests to import only tables
                              if (!empty($_POST['onlyTables'])) {
                                  $dbnameInput = !empty($_POST['dbname_import']) ? trim($_POST['dbname_import']) : 'bookfind';
                                  $sqlFilePath = 'actions/bookfind.sql';
                                  if (!file_exists($sqlFilePath)) {
                                      echo '<div class="alert alert--warning mt-3">SQL file not found.</div>';
                                      goto end_import;
                                  }
                                  // Connect directly to the provided database
                                  // (including database.php would serve the old version from the OPcache)
                                  try {
                                      $db = new PDO('mysql:host=' . $host . ';dbname=' . $dbnameInput . ';charset=utf8', $username, $password);
                                      $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
                                  } catch (PDOException $e) {
                                      echo '<div class="alert alert--danger mt-3">Cannot connect to database "' . htmlspecialchars($dbnameInput) . '": ' . htmlspecialchars($e->getMessage()) . '</div>';
                                      goto end_import;
                                  }
                                  $sql = file_get_contents($sqlFilePath);
                                  $cleanSql = preg_replace('/CREATE DATABASE\s+IF NOT EXISTS.*?;|CREATE DATABASE.*?;|USE `.*?`;/is', '', $sql);
                                  $queries = array_filter(array_map('trim', explode(';', $cleanSql)));
                                  foreach ($queries as $query) {
                                      if (!empty($query)) {
                                          try {
                                              $db->exec($query);
                                          } catch (Exception $e) {
                                              echo '<div class="alert alert--danger">SQL execution error: ' . htmlspecialchars($e->getMessage()) . '</div>';
                                          }
                                      }
                                  }
                                  // Only write the DB name to the config file once the import succeeded
                                  $filePath = 'actions/database.php';
                                  $fileContent = file_get_contents($filePath);
                                  $fileContent = preg_replace_callback('/\$dbname\s*=\s*\'[^\']*\';/', function ($m) use ($dbnameInput) {
                                      return '$dbname = ' . var_export($dbnameInput, true) . ';';
                                  }, $fileContent);
                                  file_put_contents($filePath, $fileContent);
                                  if (function_exists('opcache_invalidate')) { opcache_invalidate($filePath, true); }
                                  echo '<div class="alert alert--success mt-3">Tables imported. <a href="configuration.php">Reload the page</a>.</div>';
                                  // End of import-only-tables flow
                                  goto end_import;
                              }

                              $sqlFilePath = 'actions/bookfind.sql';
                              if (file_exists($sqlFilePath)) {
                                  $sql = file_get_contents($sqlFilePath);
                                  // Create the database without connecting to a non-existent database
                                  try {
                                      $tmpDsn = 'mysql:host=' . $host . ';charset=utf8';
                                      $tmpPdo = new PDO($tmpDsn, $username, $password);
                                      $tmpPdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
                                      $tmpPdo->exec('CREATE DATABASE IF NOT EXISTS `bookfind` DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci');
                                  } catch (Exception $e) {
                                      echo '<div class="alert alert--danger mt-3">Unable to create the database: ' . htmlspecialchars($e->getMessage()) . '</div>';
                                      // Stop here
                                      goto end_import;
                                  }
                                  // Connect directly to the newly created database
                                  // (including database.php would serve the old version from the OPcache)
                                  try {
                                      $db = new PDO('mysql:host=' . $host . ';dbname=bookfind;charset=utf8', $username, $password);
                                      $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
                                  } catch (PDOException $e) {
                                      echo '<div class="alert alert--danger mt-3">Cannot connect to database "bookfind": ' . htmlspecialchars($e->getMessage()) . '</div>';
                                      goto end_import;
                                  }
                                  // Remove any CREATE DATABASE / USE lines from the dump before execution
                                  $cleanSql = preg_replace('/CREATE DATABASE\s+IF NOT EXISTS.*?;|CREATE DATABASE.*?;|USE `.*?`;/is', '', $sql);
                                  $queries = array_filter(array_map('trim', explode(';', $cleanSql)));
                                  foreach ($queries as $query) {
                                      if (!empty($query)) {
                                          try {
                                              $db->exec($query);
                                          } catch (Exception $e) {
                                              echo '<div class="alert alert--danger">SQL execution error: ' . htmlspecialchars($e->getMessage()) . '</div>';
                                          }
                                      }
                                  }
                                  // Only write the DB name to the config file once the import succeeded
                                  $filePath = 'actions/database.php';
                                  $fileContent = file_get_contents($filePath);
                                  $fileContent = preg_replace_callback('/\$dbname\s*=\s*\'[^\']*\';/', function ($m) {
                                      return '$dbname = ' . var_export('bookfind', true) . ';';
                                  }, $fileContent);
                                  file_put_contents($filePath, $fileContent);
                                  if (function_exists('opcache_invalidate')) { opcache_invalidate($filePath, true); }
                                  echo '<div class="alert alert--success mt-3">Database imported. <a href="configuration.php">Reload the page</a>.</div>';
                              } else {
                                  echo '<div class="alert alert--warning mt-3">SQL file not found.</div>';
                              }
                          } else {
                              echo '<div class="alert alert--danger mt-3">Identifiants MySQL manquants. Remplissez d\'abord le formulaire plus haut.</div>';
                          }
                      }
                      end_import:
                      ?>
                  </div>
              </div>
          <?php } else {
              echo '<div class="alert alert--success"><svg class="icon"><use href="#i-check"/></svg><div>Step 2 completed.</div></div>';
              $step2 = true;
          } ?>

          <!-- Step 3: Create classes -->
          <div class="card">
              <div class="card__header">3. Create classes</div>
              <div class="card__body">
                  <form method="post" class="mb-3">
                      <?= csrf_field(); ?>
                      <div class="input-group">                              <input type="text" list="classes" id="class_name" name="class_name" class="input" placeholder="e.g. 6B" required>
                          <button type="submit" name="validate" class="btn btn--primary">Add</button>
                      </div>
                      <datalist id="classes">
                          <?php echo '<option value="' . htmlspecialchars($_POST['class_name'] ?? '') . '">' . htmlspecialchars($_POST['class_name'] ?? '') . '</option>'; ?>
                          <?php if (isset($db) && $db !== null) { include 'actions/functions/getClassesAndOptions.php'; } ?>
                      </datalist>
                  </form>
                  <?php
                  if (isset($_POST['validate'], $_POST['class_name']) && !empty($_POST['class_name'])) {
                      if (!empty($host) && !empty($dbname) && !empty($username) && isset($db) && $db !== null) {
                          $class_name = $_POST['class_name'];
                          $checkIfClassAlreadyExists = $db->prepare('SELECT name FROM classes WHERE name = ?');
                          $checkIfClassAlreadyExists->execute([$class_name]);
                          if ($checkIfClassAlreadyExists->rowCount() == 0) {
                              $addClass = $db->prepare('INSERT INTO classes SET name = ?');
                              $addClass->execute([$class_name]);
                              echo '<div class="alert alert--success mt-3">Class added successfully.</div>';
                          } else {
                              echo '<div class="alert alert--warning mt-3">This class already exists.</div>';
                          }
                      } else {
                          echo '<div class="alert alert--danger mt-3">Identifiants MySQL manquants. Remplissez d\'abord le formulaire plus haut.</div>';
                      }
                  }

                  if (!empty($host) && !empty($dbname) && !empty($username) && isset($db) && $db !== null) {
                      $checkIfClassExists = $db->query('SELECT name FROM classes');
                      if ($checkIfClassExists->rowCount() > 0) {
                          echo '<div class="alert alert--success"><svg class="icon"><use href="#i-check"/></svg><div>Step 3 completed.</div></div>';
                          $step3 = true;
                      }
                  }
                  ?>
              </div>
          </div>

          <!-- Step 4: Administrator account -->
          <?php $dbOk = isset($db) && $db !== null;
          $hasUsers = $dbOk && $db->query('SELECT id FROM users')->rowCount() > 0;
          if (!$hasUsers) { ?>
              <div class="alert alert--info">
                  <svg class="icon"><use href="#i-info"/></svg>
                  <div>4. Create the first administrator account by signing up via the <a href="signup.php">signup page</a>.</div>
              </div>
          <?php } else {
              echo '<div class="alert alert--success"><svg class="icon"><use href="#i-check"/></svg><div>Step 4 completed.</div></div>';
              $step4 = true;
          } ?>

          <!-- Remove configuration file -->
          <?php if (isset($step1, $step2, $step3, $step4) && $step1 && $step2 && $step3 && $step4) { ?>
              <div class="card">
                  <div class="card__body center">
                      <h2>Congratulations! Configuration complete.</h2>
                      <p class="text-subtle">For security reasons, please delete this file.</p>
                      <form method="post">
                          <?= csrf_field(); ?>
                          <button type="submit" name="delete" class="btn btn--danger">
                              <svg class="icon"><use href="#i-trash"/></svg>Delete this file
                          </button>
                      </form>
                  </div>
              </div>
          <?php if (isset($_POST['delete'])) {
                  unlink('configuration.php');
                  echo '<div class="alert alert--success mt-3">File deleted successfully. You can now access the <a href="index.php">site</a>.</div>';
              }
          } ?>
        </div>
      </div>
    </main>
    <?php include 'includes/footer.php'; ?>
</body>

</html>
