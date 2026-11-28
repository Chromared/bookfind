<?php require_once dirname(__DIR__, 3) . '/includes/paths.php'; ?>
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
require ROOT_PATH . '/actions/database.php';
// Access guard: verify session and admin authorization
// For AJAX endpoints, do not include handlers that redirect to an HTML page.
// Check session and rights here and return JSON + HTTP status code if unauthorized.
if (empty($_SESSION['auth'])) {
    http_response_code(401);
    echo json_encode(['error' => 'Unauthenticated']);
    exit();
}
// Check graded role (grade '1' or '2', same as securityAdminAction.php)
if (!isset($_SESSION['grade']) || $_SESSION['grade'] == '0') {
    http_response_code(403);
    echo json_encode(['error' => 'Forbidden']);
    exit();
}

// Retrieve total number of users
$usersQuery = $db->query('SELECT COUNT(*) AS total_users FROM users');
$usersResult = $usersQuery->fetch();
$totalUsers = $usersResult['total_users'];

$booksQuery = $db->query('SELECT COUNT(*) AS total_books FROM books');
$booksResult = $booksQuery->fetch();
$totalBooks = $booksResult['total_books'];

$loansQuery = $db->query('SELECT COUNT(*) AS total_loans FROM loans WHERE status = 1');
$loansResult = $loansQuery->fetch();
$totalLoans = $loansResult['total_loans'];

$returnedLoansQuery = $db->query('SELECT COUNT(*) AS total_returned_loans FROM loans WHERE status = 2');
$returnedLoansResult = $returnedLoansQuery->fetch();
$totalReturnedLoans = $returnedLoansResult['total_returned_loans'];

$availableBooksQuery = $db->query('SELECT COUNT(*) AS total_available_books FROM books WHERE status = 0');
$availableBooksResult = $availableBooksQuery->fetch();
$totalAvailableBooks = $availableBooksResult['total_available_books'];

$overdueLoansQuery = $db->query('SELECT COUNT(*) AS total_overdue_loans FROM loans WHERE status = 1 AND due_date < CURDATE()');
$overdueLoansResult = $overdueLoansQuery->fetch();
$totalOverdueLoans = $overdueLoansResult['total_overdue_loans'];

$logsQuery = $db->query('SELECT COUNT(*) AS total_logs FROM logs');
$logsResult = $logsQuery->fetch();
$totalLogs = $logsResult['total_logs'];

if (!$usersResult || !$booksResult || !$loansResult || !$returnedLoansResult || !$availableBooksResult || !$overdueLoansResult || !$logsResult) {
    echo json_encode(['error' => 'Error retrieving data']);
    exit();
}

echo json_encode([
    'total_users' => $totalUsers,
    'total_books' => $totalBooks,
    'total_loans' => $totalLoans,
    'total_returned_loans' => $totalReturnedLoans,
    'total_available_books' => $totalAvailableBooks,
    'total_overdue_loans' => $totalOverdueLoans,
    'total_logs' => $totalLogs,
]);
?>
