<?php
//This file belongs to the BookFind project.
//
//BookFind is distributed under the terms of the GNU Affero General Public License v3.0.
//
//Copyright (C) 2025 Chromared
?>



<?php require_once __DIR__ . '/../../../actions/functions/sessionInit.php'; // Import users via CSV

$otherValueOption = 'other';

// Initialize variables
$msgImport = "";
$alertImportType = "warning";

// Retrieve database connection (used globally)
global $db;

$maxAge = 24 * 60 * 60; // 24 hours
// Automatic cleanup of temporary files older than 24 hours
$tempDir = __DIR__ . '/../../../temp';
if (is_dir($tempDir)) {
    $files = glob($tempDir . '/csv_import_*.csv');
    $maxAge = 24 * 60 * 60; // 24 hours
    $now = time();

    foreach ($files as $file) {
        if (is_file($file) && ($now - filemtime($file)) > $maxAge) {
            @unlink($file);
        }
    }
}

// Step 1: Upload and analyze CSV
if(isset($_POST['csvUpload'])) {
    if(!isset($_FILES['csvFile']) || $_FILES['csvFile']['error'] !== UPLOAD_ERR_OK) {
        $msgImport = _('Error uploading the file. Please try again.');
    } else {
        $separator = $_POST['csvSeparator'] ?? ',';
        if ($separator === '\\t') {
            $separator = "\t";
        }
        if (!in_array($separator, [',', ';', "\t", '|'], true)) {
            $separator = ',';
        }
        $hasHeaders = isset($_POST['csvHasHeaders']) && (string)$_POST['csvHasHeaders'] === '0' ? 0 : 1;
        $_SESSION['csv_has_headers'] = $hasHeaders;

        $csvFile = $_FILES['csvFile']['tmp_name'];

        // Check file existence
        if (!file_exists($csvFile)) {
            $msgImport = _('The uploaded file cannot be found. Please try again.');
        } else {
            // Check CSV format
            $fileType = mime_content_type($csvFile);
            if ($fileType !== 'text/csv' && $fileType !== 'text/plain') {
                $msgImport = _('The file must be in CSV format.');
            } else {
                // Read CSV file
                $csvData = [];
                $headers = [];

                if (($handle = @fopen($csvFile, "r")) !== FALSE) {
                    // Read the first line
                    $firstLine = fgetcsv($handle, 0, $separator, '"', "\\");

                    if (!$firstLine) {
                        $msgImport = _('Unable to read the CSV file.');
                        fclose($handle);
                    } else {
                        if ($hasHeaders) {
                            // Use first line as headers
                            $headers = $firstLine;
                            if (isset($headers[0])) {
                                $headers[0] = preg_replace('/^\xEF\xBB\xBF/', '', $headers[0]);
                            }
                        } else {
                            // Create generic headers with preview of the first line
                            $headers = array_map(function($i, $value) {
                                return "Column $i: " . (isset($value) ? substr($value, 0, 15) . (strlen($value) > 15 ? '...' : '') : '');
                            }, array_keys($firstLine), $firstLine);

                            // Treat first line as data
                            $csvData[] = $firstLine;
                        }

                        // Read data (max 5 rows for preview)
                        $previewRows = count($csvData); // 0 or 1 depending on whether the first line was already added
                        while ($previewRows < 5 && ($data = fgetcsv($handle, 0, $separator, '"', "\\")) !== FALSE) {
                            $csvData[] = $data;
                            $previewRows++;
                        }

                        // Continue reading the rest of the data without storing (just to count)
                        $totalRows = $previewRows;
                        while (($data = fgetcsv($handle, 0, $separator, '"', "\\")) !== FALSE) {
                            $totalRows++;
                        }

                        fclose($handle);

                        // Create dedicated temporary folder if needed
                        $tempDir = __DIR__ . '/../../../temp';
                        if (!is_dir($tempDir)) {
                            @mkdir($tempDir, 0755, true);
                        }

                        // Generate unique filename with timestamp
                        $uniqueId = uniqid('csv_import_', true);
                        $tempFile = $tempDir . '/' . $uniqueId . '.csv';

                        if (@copy($csvFile, $tempFile)) {
                            // Store only metadata in session (not data)
                            $_SESSION['csv_headers'] = $headers;
                            $_SESSION['csv_separator'] = $separator;
                            $_SESSION['csv_file'] = $tempFile;
                            $_SESSION['total_rows'] = $totalRows;
                            $_SESSION['csv_preview'] = $csvData; // Only 5 rows for preview

                            $msgImport = sprintf(_('CSV file analyzed successfully. %d rows found. Please map the columns.'), $totalRows);
                            $alertImportType = "success";
                        } else {
                            $msgImport = _('Error processing the file. Please try again.');
                        }
                    }
                } else {
                    $msgImport = _('Unable to open the CSV file.');
                }
            }
        }
    }
}

// Cancel import
if(isset($_POST['csvCancel'])) {
    if (isset($_SESSION['csv_file']) && file_exists($_SESSION['csv_file'])) {
        @unlink($_SESSION['csv_file']);
    }

    unset($_SESSION['csv_headers']);
    unset($_SESSION['csv_separator']);
    unset($_SESSION['csv_file']);
    unset($_SESSION['total_rows']);
    unset($_SESSION['csv_has_headers']);
    unset($_SESSION['csv_preview']);

    $msgImport = _('Import canceled.');
}

// Step 2: Import data
if(isset($_POST['csvImport'])) {
    if(!isset($_SESSION['csv_file']) || !file_exists($_SESSION['csv_file']) || !isset($_SESSION['csv_headers']) || !isset($_SESSION['csv_separator'])) {
        $msgImport = _('No CSV file awaiting import.');
    } else {
        $db_mapping = $_POST['db_mapping'] ?? [];
        $allowedColumns = ['username', 'last_name', 'first_name', 'class_name', 'grade', 'rules_accepted', 'privacy_accepted', 'max_loans', 'password'];
        $mappingIsValid = is_array($db_mapping);
        if ($mappingIsValid) {
            foreach ($db_mapping as $column => $csvIndex) {
                if (!in_array($column, $allowedColumns, true) || !is_scalar($csvIndex)) {
                    $mappingIsValid = false;
                    break;
                }

                $csvIndex = (string)$csvIndex;
                $db_mapping[$column] = $csvIndex;
                if (ctype_digit($csvIndex) && (int)$csvIndex < count($_SESSION['csv_headers'])) {
                    continue;
                }

                $allowedOptions = match ($column) {
                    'username' => ['algorithm'],
                    'grade' => ['fixed:0', 'fixed:1', 'fixed:2', 'fixed:3'],
                    'rules_accepted', 'privacy_accepted' => ['fixed:0', 'fixed:1'],
                    'password' => ['', $otherValueOption, 'fixed:default'],
                    default => ['', $otherValueOption],
                };
                if ($column === 'username') {
                    $allowedOptions[] = $otherValueOption;
                }
                if (!in_array($csvIndex, $allowedOptions, true)) {
                    $mappingIsValid = false;
                    break;
                }
            }
        }

        // Verify username mapping
        if (!$mappingIsValid) {
            $msgImport = _('The column mapping is invalid. Please map the CSV columns again.');
        } elseif (!isset($db_mapping['username']) ||
            ($db_mapping['username'] === $otherValueOption && empty($_POST['custom_username'])) ||
            (!is_numeric($db_mapping['username']) && !in_array($db_mapping['username'], [$otherValueOption, 'algorithm'], true))) {
            $msgImport = _('The column mapping is incorrect. The username field is required.');
        } else {
            // Retrieve custom values
            $custom_username = isset($_POST['custom_username']) ? trim($_POST['custom_username']) : null;
            $custom_last_name = isset($_POST['custom_last_name']) ? trim($_POST['custom_last_name']) : null;
            $custom_first_name = isset($_POST['custom_first_name']) ? trim($_POST['custom_first_name']) : null;
            $custom_class_name = isset($_POST['custom_class_name']) ? trim($_POST['custom_class_name']) : null;
            $custom_password = isset($_POST['custom_password']) ? (string)$_POST['custom_password'] : null;
            $custom_max_loans = isset($_POST['custom_max_loans']) && is_numeric($_POST['custom_max_loans']) ? (int)$_POST['custom_max_loans'] : null;

            try {
                // We use the $db connection already established in database.php

                $csvFile = $_SESSION['csv_file'];
                $separator = $_SESSION['csv_separator'];
                $headers = $_SESSION['csv_headers'];
                $hasHeaders = $_SESSION['csv_has_headers'] ?? 1;

                $importedCount = 0;
                $errorCount = 0;
                $errors = [];

                if (($handle = @fopen($csvFile, "r")) !== FALSE) {
                    // Skip first line if it's headers
                    if ($hasHeaders) {
                        fgetcsv($handle, 0, $separator, '"', "\\");
                    }

                    // Line counter for error tracking
                    $lineNumber = $hasHeaders ? 2 : 1;

                    while (($data = fgetcsv($handle, 0, $separator, '"', "\\")) !== FALSE) {
                        // Handle rows with incorrect column count
                        if (count($data) !== count($headers)) {
                            $errors[] = sprintf(_('Line %d: Incorrect number of columns.'), $lineNumber);
                            $errorCount++;
                            $lineNumber++;
                            continue;
                        }

                        $userData = [];

                        // Map columns according to the mapping
                        foreach ($db_mapping as $dbColumn => $csvIndex) {
                            if (ctype_digit((string)$csvIndex)) {
                                $columnIndex = (int)$csvIndex;
                                if (array_key_exists($columnIndex, $data)) {
                                    $userData[$dbColumn] = $data[$columnIndex];
                                }
                            }
                        }

                        // Process last name and first name
                        if (isset($db_mapping['last_name']) && $db_mapping['last_name'] === $otherValueOption) {
                            $userData['last_name'] = $custom_last_name;
                        } else if (!isset($userData['last_name'])) {
                            $userData['last_name'] = '';
                        }

                        if (isset($db_mapping['first_name']) && $db_mapping['first_name'] === $otherValueOption) {
                            $userData['first_name'] = $custom_first_name;
                        } else if (!isset($userData['first_name'])) {
                            $userData['first_name'] = '';
                        }

                        // Handle username processing
                        if (isset($db_mapping['username']) && $db_mapping['username'] === $otherValueOption) {
                            $userData['username'] = $custom_username;
                        } elseif (isset($db_mapping['username']) && $db_mapping['username'] === 'algorithm') {
                            // Generation algorithm: first letter of first name + first 7 letters of last name
                            if (!empty($userData['first_name']) && !empty($userData['last_name'])) {
                                $userData['username'] = strtolower(substr($userData['first_name'], 0, 1) . substr($userData['last_name'], 0, 7));
                            } else {
                                $errors[] = sprintf(_('Line %d: Unable to generate username (missing last name or first name).'), $lineNumber);
                                $errorCount++;
                                $lineNumber++;
                                continue;
                            }
                        }

                        // Ensure username is not empty and fits the database column.
                        if (isset($userData['username'])) {
                            $userData['username'] = mb_substr(trim((string)$userData['username']), 0, 10, 'UTF-8');
                        }
                        if (empty($userData['username'])) {
                            $errors[] = sprintf(_('Line %d: Empty username.'), $lineNumber);
                            $errorCount++;
                            $lineNumber++;
                            continue;
                        }

                        // Process class
                        if (isset($db_mapping['class_name']) && $db_mapping['class_name'] === $otherValueOption) {
                            $userData['class_name'] = $custom_class_name;
                            if ($userData['class_name'] === null || $userData['class_name'] === '') {
                                $errors[] = sprintf(_('Line %d: Class is required.'), $lineNumber);
                                $errorCount++;
                                $lineNumber++;
                                continue;
                            }
                        } else if (!isset($userData['class_name'])) {
                            $userData['class_name'] = '';
                        }

                        // Handle password processing
                        if (isset($db_mapping['password']) && $db_mapping['password'] === $otherValueOption) {
                            if ($custom_password === null || $custom_password === '') {
                                $errors[] = sprintf(_('Line %d: Password is required.'), $lineNumber);
                                $errorCount++;
                                $lineNumber++;
                                continue;
                            }
                            $userData['password'] = password_hash($custom_password, PASSWORD_DEFAULT);
                        } elseif (($db_mapping['password'] ?? '') === 'fixed:default' || !isset($userData['password']) || empty($userData['password'])) {
                            $userData['password'] = password_hash('ChangeMe123!', PASSWORD_DEFAULT);
                        } else {
                            $userData['password'] = password_hash($userData['password'], PASSWORD_DEFAULT);
                        }

                        // Process numeric values
                        // Grade with predefined options
                        if (isset($db_mapping['grade']) && str_starts_with((string)$db_mapping['grade'], 'fixed:')) {
                            $userData['grade'] = (int)substr($db_mapping['grade'], 6);
                        } elseif (isset($userData['grade'])) {
                            $userData['grade'] = (int)$userData['grade'];
                        } else {
                            $userData['grade'] = 0;
                        }
                        $userData['grade'] = max(0, min(3, $userData['grade']));

                        // Apply fixed-value mapping defaults to flags as well as grades.
                        foreach (['rules_accepted', 'privacy_accepted'] as $flagColumn) {
                            if (isset($db_mapping[$flagColumn]) && str_starts_with((string)$db_mapping[$flagColumn], 'fixed:')) {
                                $userData[$flagColumn] = (int)substr($db_mapping[$flagColumn], 6);
                            }
                            $userData[$flagColumn] = isset($userData[$flagColumn]) ? (int)$userData[$flagColumn] : 0;
                        }

                        // Max borrow count
                        if (isset($db_mapping['max_loans']) && $db_mapping['max_loans'] === $otherValueOption) {
                            if ($custom_max_loans === null || $custom_max_loans < 1) {
                                $errors[] = sprintf(_('Line %d: Maximum loans must be at least 1.'), $lineNumber);
                                $errorCount++;
                                $lineNumber++;
                                continue;
                            }
                            $userData['max_loans'] = $custom_max_loans;
                        } elseif (!isset($userData['max_loans']) || empty($userData['max_loans'])) {
                            $userData['max_loans'] = 5;
                        }

                        // Additional default values
                        $userData['loans_count'] = 0;
                        $userData['theme'] = 0;

                        try {
                            // Check if user already exists
                            $checkUser = $db->prepare('SELECT id FROM users WHERE username = ?');
                            $checkUser->execute([$userData['username']]);

                            if($checkUser->rowCount() > 0) {
                                    // Update existing user
                                $sql = 'UPDATE users SET ';
                                $params = [];
                                $updates = [];

                                foreach ($userData as $column => $value) {
                                    if ($column !== 'username') {
                                        $updates[] = "$column = ?";
                                        $params[] = $value;
                                    }
                                }

                                $sql .= implode(', ', $updates);
                                $sql .= ' WHERE username = ?';
                                $params[] = $userData['username'];

                                $stmt = $db->prepare($sql);
                                $stmt->execute($params);
                            } else {
                                // Insert a new user
                                $columns = implode(', ', array_keys($userData));
                                $placeholders = implode(', ', array_fill(0, count($userData), '?'));

                                $sql = "INSERT INTO users ($columns) VALUES ($placeholders)";
                                $stmt = $db->prepare($sql);
                                $stmt->execute(array_values($userData));
                            }

                            $importedCount++;

                        } catch (PDOException $e) {
                            error_log('CSV user import failed on line ' . $lineNumber . ': ' . $e->getMessage());
                            $errors[] = sprintf(_('Line %d: The row could not be imported.'), $lineNumber);
                            $errorCount++;
                        }

                        $lineNumber++;
                    }

                    fclose($handle);

                    // Delete temporary file
                    if (file_exists($_SESSION['csv_file'])) {
                        @unlink($_SESSION['csv_file']);
                    }

                    // Clean up session
                    unset($_SESSION['csv_headers']);
                    unset($_SESSION['csv_separator']);
                    unset($_SESSION['csv_file']);
                    unset($_SESSION['csv_total_rows']);
                    unset($_SESSION['csv_has_headers']);
                    unset($_SESSION['csv_preview']);

                    SaveLog($db, $_SERVER['REQUEST_URI'], 'Import users via CSV', $importedCount . ' users imported');

                    $msgImport = sprintf(_('Import completed: %1$d users imported, %2$d errors.'), $importedCount, $errorCount);
                    if (!empty($errors)) {
                        $msgImport .= "<br><strong>Error details:</strong><ul>";
                        foreach(array_slice($errors, 0, 5) as $error) {
                            $msgImport .= "<li>" . htmlspecialchars($error) . "</li>";
                        }
                        if (count($errors) > 5) {
                            $msgImport .= "<li>" . sprintf(_('%d more errors.'), count($errors) - 5) . "</li>";
                        }
                        $msgImport .= "</ul>";
                    }
                    $alertImportType = ($errorCount > 0) ? "warning" : "success";
                } else {
                    $msgImport = _('Unable to open the CSV file.');
                }
            } catch (Throwable $e) {
                error_log('CSV user import failed: ' . $e->getMessage());
                $msgImport = _('Database connection error. Please check the server logs.');
            }
        }
    }
}

// Return to the calling script with the messages
return [
    'msgImport' => $msgImport,
    'alertImportType' => $alertImportType
];