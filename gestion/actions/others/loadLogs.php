<?php
//This file belongs to the BookFind project.
//
//BookFind is distributed under the terms of the MIT software license.
//
//Copyright (C) 2025 Chromared
?>



<?php require_once __DIR__ . '/../../../actions/functions/sessionInit.php';
  require_once '../../../actions/database.php';
    // For AJAX requests, return 401/403 rather than an HTML page
  if (empty($_SESSION['auth'])) {
      http_response_code(401);
      exit();
  }
  if (!isset($_SESSION['grade']) || $_SESSION['grade'] == '0') {
      http_response_code(403);
      exit();
  }
    require_once '../../../actions/functions/conversionDateHour.php';

    // Purge old logs: run rarely (approx. 1% of requests)
    if (mt_rand(1, 100) === 1) {
        $twoYearsAgo = (new DateTime())->modify('-730 days')->format('Y-m-d H:i:s');
        $query = $bdd->prepare("DELETE FROM logs WHERE datetime <= ?");
        $query->execute([$twoYearsAgo]);
    }

    // Pagination/search parameters
    $page = max(1, (int)($_GET['page'] ?? 1));
    $perPage = isset($_GET['per_page']) ? max(1, min(200, (int)$_GET['per_page'])) : 50; // cap 200
    $showAll = isset($_GET['show_all']) && ($_GET['show_all'] === '1' || $_GET['show_all'] === 'true');
    $q = trim((string)($_GET['q'] ?? ''));

    // Build WHERE clause for search (if provided)
    $where = '';
    $params = [];
    if ($q !== '') {
        $like = '%' . str_replace('%', '\\%', $q) . '%';
        $where = 'WHERE (type LIKE ? OR user_name LIKE ? OR comment LIKE ? OR page LIKE ? OR user_ip LIKE ?)';
        $params = [$like, $like, $like, $like, $like];
    }

    // Calculate total for pagination
    $countSql = 'SELECT COUNT(*) AS total FROM logs ' . $where;
    $countStmt = $bdd->prepare($countSql);
    $countStmt->execute($params);
    $total = (int) ($countStmt->fetchColumn() ?? 0);

    // Reasonable limit if 'show_all' requested
    if ($showAll) {
        $perPage = max(100, min(1000, $total));
        $page = 1;
    }

    $offset = ($page - 1) * $perPage;

    // Retrieve only necessary fields
    $sql = 'SELECT type, user_name, comment, datetime, user_ip, page, user_id FROM logs ' . $where . ' ORDER BY datetime DESC';
    if (!$showAll) {
        // MySQL does not always support placeholders for LIMIT/OFFSET depending on configuration.
        // Values are cast to int below to prevent injection.
        $sql .= ' LIMIT ' . ((int)$perPage) . ' OFFSET ' . ((int)$offset);
        $stmt = $bdd->prepare($sql);
        $stmt->execute($params);
    } else {
        $stmt = $bdd->prepare($sql);
        $stmt->execute($params);
    }
    $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);

    // Build output in memory to reduce echo calls
    $out = '';
    foreach ($rows as $log) {
        $dateFormattee = date("d/m/Y à H:i:s", strtotime($log['datetime'] ?? ''));
        $type = htmlspecialchars($log['type'] ?? '', ENT_QUOTES);
        $user_name = htmlspecialchars($log['user_name'] ?? '', ENT_QUOTES);
        // The comment field was sanitized on insertion via SaveLog(); it contains only safe fragments (text + <a>).
        $comment = $log['comment'] ?? '';
        $user_ip = htmlspecialchars($log['user_ip'] ?? '', ENT_QUOTES);
        $log_page = htmlspecialchars($log['page'] ?? '', ENT_QUOTES);
        $user_id = (int) ($log['user_id'] ?? 0);

        $out .= '<div class="container mt-3">'
            . '<div class="d-flex justify-content-center mt-4">'
            . '<div class="card text-center mb-3" style="width: 50rem;">'
            . '<div class="card-body">'
            . '<h5 class="card-title">' . $type . '</h5>'
            . '<h6 class="card-subtitle mb-2 text-body-secondary">' . $user_name . '</h6>'
            . '<p class="card-text">' . $comment . '</p>'
            . '<ul class="list-group list-group-flush">'
            . '<li class="list-group-item">Le ' . $dateFormattee . '</li>'
            . '<li class="list-group-item">' . $user_ip . '</li>'
            . '<li class="list-group-item"><a href="' . $log_page . '" class="card-link">' . $log_page . '</a></li>'
            . '<li class="list-group-item"><a href="../profil.php?id=' . $user_id . '" class="btn btn-primary">Voir l\'utilisateur</a></li>'
            . '</ul></div></div></div></div>';
    }

    // Pagination HTML (numbered, condensed window)
    $totalPages = $perPage > 0 ? (int) ceil($total / $perPage) : 1;
    $out .= '<div class="container mt-2"><div class="d-flex justify-content-center align-items-center flex-wrap gap-1">';

    // Prev
    if ($page > 1) {
        $out .= '<button class="btn btn-outline-secondary me-2 log-page-btn" data-page="' . ($page - 1) . '">Précédent</button>';
    }

    if (!$showAll) {
        $maxButtons = 7; // maximum number of numeric buttons displayed
        if ($totalPages <= $maxButtons) {
            for ($p = 1; $p <= $totalPages; $p++) {
                $cls = $p == $page ? 'btn-primary' : 'btn-outline-secondary';
                $out .= '<button class="btn ' . $cls . ' log-page-btn" data-page="' . $p . '">' . $p . '</button>';
            }
        } else {
            $side = (int) floor(($maxButtons - 3) / 2); // space around current page
            $start = max(2, $page - $side);
            $end = min($totalPages - 1, $page + $side);
            // adjust if close to edges
            if ($start <= 2) {
                $start = 2;
                $end = $start + ($maxButtons - 3);
            }
            if ($end >= $totalPages - 1) {
                $end = $totalPages - 1;
                $start = $end - ($maxButtons - 3);
            }

            // first
            $cls = 1 == $page ? 'btn-primary' : 'btn-outline-secondary';
            $out .= '<button class="btn ' . $cls . ' log-page-btn" data-page="1">1</button>';
            if ($start > 2) $out .= '<span class="mx-1">…</span>';

            for ($p = $start; $p <= $end; $p++) {
                $cls = $p == $page ? 'btn-primary' : 'btn-outline-secondary';
                $out .= '<button class="btn ' . $cls . ' log-page-btn" data-page="' . $p . '">' . $p . '</button>';
            }

            if ($end < $totalPages - 1) $out .= '<span class="mx-1">…</span>';
            $cls = $totalPages == $page ? 'btn-primary' : 'btn-outline-secondary';
            $out .= '<button class="btn ' . $cls . ' log-page-btn" data-page="' . $totalPages . '">' . $totalPages . '</button>';
        }
    } else {
        // when show_all enabled, do not offer numbered pagination
        $out .= '<span class="text-muted">Affichage complet (' . $total . ' entrées)</span>';
    }

    // Next
    if (!$showAll && $page < $totalPages) {
        $out .= '<button class="btn btn-outline-secondary ms-2 log-page-btn" data-page="' . ($page + 1) . '">Suivant</button>';
    }

    // Show all / revert button
    if (!$showAll) {
        $out .= '<button class="btn btn-outline-primary ms-3 log-showall-btn" data-showall="1">Tout afficher</button>';
    } else {
        $out .= '<button class="btn btn-outline-primary ms-3 log-showall-btn" data-showall="0">Limiter l\'affichage</button>';
    }

    $out .= '</div></div>';

    echo $out;