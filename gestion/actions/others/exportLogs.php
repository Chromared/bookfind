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



<?php require_once __DIR__ . '/../../../actions/functions/sessionInit.php'; if (isset($_POST['export'])) {
    // Clean output buffer to avoid unwanted newlines
    if (ob_get_length()) ob_clean();

    // Retrieve logs
    $req = $db->query("SELECT user_id, user_ip, user_card, user_name, type, comment, page, datetime FROM logs");
    $logs = $req->fetchAll(PDO::FETCH_ASSOC);

    // Check if logs exist
    if (empty($logs)) {
        die(bookfind_translate("No logs found."));
    }

    // Set content type to CSV
    header('Content-Type: text/csv; charset=UTF-8');
    header('Content-Disposition: attachment; filename="logs_bookfind_' . time() . '.csv"');

    // Open output as stream
    $output = fopen('php://output', 'w');

    // Add BOM to avoid encoding issues with Excel
    fwrite($output, "\xEF\xBB\xBF");

    // Write CSV header
    fputcsv($output, array_keys($logs[0]));

    // Write log rows
    foreach ($logs as $log) {
        fputcsv($output, $log);
    }

    fclose($output);

    SaveLog($db, $_SERVER['REQUEST_URI'], 'Logs export', 'Commits to comply with GDPR and acknowledges that logs may contain personal data.');

    exit();
}