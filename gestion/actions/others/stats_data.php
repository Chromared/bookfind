<?php
//This file belongs to the BookFind project.
//
//BookFind is distributed under the terms of the GNU Affero General Public License v3.0.
//
//Copyright (C) 2025 Chromared
?>

<?php require_once __DIR__ . '/../../../actions/functions/sessionInit.php';
require '../../../actions/database.php';
// Access guard: verify session and graded authorization (same as securityAdminAction.php)
// For AJAX endpoints, do not include handlers that redirect to an HTML page.
// Check session and rights here and return JSON + HTTP status code if unauthorized.
if (empty($_SESSION['auth'])) {
    http_response_code(401);
    echo json_encode(['error' => 'Unauthenticated']);
    exit();
}
if (!isset($_SESSION['grade']) || $_SESSION['grade'] == '0') {
    http_response_code(403);
    echo json_encode(['error' => 'Forbidden']);
    exit();
}

header('Content-Type: application/json; charset=utf-8');

$data = [];

// Monthly loans (last 6 months, including the current month)
$monthlyQuery = $db->query(
    "SELECT DATE_FORMAT(loan_date, '%Y-%m') AS month, COUNT(*) AS nb
     FROM loans
     WHERE loan_date >= DATE_SUB(CURDATE(), INTERVAL 5 MONTH)
     GROUP BY month
     ORDER BY month"
);
$data['monthly_loans'] = $monthlyQuery->fetchAll(PDO::FETCH_ASSOC);

// Loan evolution over 12 months (line chart)
$evolutionQuery = $db->query(
    "SELECT DATE_FORMAT(loan_date, '%Y-%m') AS month, COUNT(*) AS nb
     FROM loans
     WHERE loan_date >= DATE_SUB(CURDATE(), INTERVAL 11 MONTH)
     GROUP BY month
     ORDER BY month"
);
$data['evolution_12_months'] = $evolutionQuery->fetchAll(PDO::FETCH_ASSOC);

// Loan distribution by status (exclusive buckets)
$statusQuery = $db->query(
    "SELECT
        SUM(status = 1) AS in_progress,
        SUM(status = 1 AND due_date < CURDATE()) AS overdue,
        SUM(status = 2) AS returned
     FROM loans"
)->fetch();
$overdueCount = (int)($statusQuery['overdue'] ?? 0);
$data['loans_by_status'] = [
    ['label' => 'Overdue', 'nb' => $overdueCount],
    ['label' => 'In progress', 'nb' => (int)($statusQuery['in_progress'] ?? 0) - $overdueCount],
    ['label' => 'Returned', 'nb' => (int)($statusQuery['returned'] ?? 0)],
];

// Top borrowers (5 most active users)
$borrowersQuery = $db->query(
    "SELECT CONCAT(u.first_name, ' ', u.last_name) AS label, COUNT(e.id) AS nb
     FROM loans e
     JOIN users u ON u.id = e.borrower_id
     GROUP BY u.id
     ORDER BY nb DESC, label ASC
     LIMIT 5"
);
$data['top_borrowers'] = $borrowersQuery->fetchAll(PDO::FETCH_ASSOC);

// User distribution by class
$classQuery = $db->query('SELECT class_name AS label, COUNT(*) AS nb FROM users GROUP BY class_name ORDER BY nb DESC');
$data['users_by_class'] = $classQuery->fetchAll(PDO::FETCH_ASSOC);

// Rate of books currently on loan (gauge)
$occupationQuery = $db->query('SELECT status, COUNT(*) AS nb FROM books GROUP BY status')->fetchAll(PDO::FETCH_ASSOC);
$onLoanCount = 0;
$availableCount = 0;
foreach ($occupationQuery as $row) {
    if ((int)$row['status'] === 1) {
        $onLoanCount = (int)$row['nb'];
    } else {
        $availableCount = (int)$row['nb'];
    }
}
$data['books_occupancy'] = [
    'on_loan' => $onLoanCount,
    'available' => $availableCount,
    'total' => $onLoanCount + $availableCount,
];

echo json_encode($data);
