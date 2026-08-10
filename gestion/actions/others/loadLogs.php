<?php
//This file belongs to the BookFind project.
//
//BookFind is distributed under the terms of the MIT software license.
//
//Copyright (C) 2025 Chromared
?>



<?php require_once __DIR__ . '/../../../actions/functions/sessionInit.php';
  require_once '../../../actions/database.php';
  // Pour les requêtes AJAX, retourner 401/403 plutôt qu'une page HTML
  if (empty($_SESSION['auth'])) {
      http_response_code(401);
      exit();
  }
  if (!isset($_SESSION['grade']) || $_SESSION['grade'] == '0') {
      http_response_code(403);
      exit();
  }
    require_once '../../../actions/functions/conversionDateHour.php';

    // Suppression des logs anciens : exécuter rarement (approx. 1% des requêtes)
    if (mt_rand(1, 100) === 1) {
        $twoYearsAgo = (new DateTime())->modify('-730 days')->format('Y-m-d H:i:s');
        $query = $bdd->prepare("DELETE FROM logs WHERE datetime <= ?");
        $query->execute([$twoYearsAgo]);
    }

    // Paramètres de pagination / recherche
    $page = max(1, (int)($_GET['page'] ?? 1));
    $perPage = isset($_GET['per_page']) ? max(1, min(200, (int)$_GET['per_page'])) : 50; // cap 200
    $showAll = isset($_GET['show_all']) && ($_GET['show_all'] === '1' || $_GET['show_all'] === 'true');
    $q = trim((string)($_GET['q'] ?? ''));

    // Construire la clause WHERE pour la recherche (si fournie)
    $where = '';
    $params = [];
    if ($q !== '') {
        $like = '%' . str_replace('%', '\\%', $q) . '%';
        $where = 'WHERE (type LIKE ? OR user_name LIKE ? OR comment LIKE ? OR page LIKE ? OR user_ip LIKE ?)';
        $params = [$like, $like, $like, $like, $like];
    }

    // Calculer total pour pagination
    $countSql = 'SELECT COUNT(*) AS total FROM logs ' . $where;
    $countStmt = $bdd->prepare($countSql);
    $countStmt->execute($params);
    $total = (int) ($countStmt->fetchColumn() ?? 0);

    // Limite raisonnable si 'show_all' demandé
    if ($showAll) {
        $perPage = max(100, min(1000, $total));
        $page = 1;
    }

    $offset = ($page - 1) * $perPage;

    // Récupérer uniquement les champs nécessaires
    $sql = 'SELECT type, user_name, comment, datetime, user_ip, page, user_id FROM logs ' . $where . ' ORDER BY datetime DESC';
    if (!$showAll) {
        // MySQL ne supporte pas toujours des placeholders pour LIMIT/OFFSET selon la configuration.
        // Les valeurs sont castées en int ci‑dessous pour éviter toute injection.
        $sql .= ' LIMIT ' . ((int)$perPage) . ' OFFSET ' . ((int)$offset);
        $stmt = $bdd->prepare($sql);
        $stmt->execute($params);
    } else {
        $stmt = $bdd->prepare($sql);
        $stmt->execute($params);
    }
    $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);

    // Construire la sortie en mémoire pour réduire les appels echo
    $out = '';
    foreach ($rows as $log) {
        $dateFormattee = date("d/m/Y à H:i:s", strtotime($log['datetime'] ?? ''));
        $type = htmlspecialchars($log['type'] ?? '', ENT_QUOTES);
        $user_name = htmlspecialchars($log['user_name'] ?? '', ENT_QUOTES);
        // Le champ comment a été nettoyé à l'insertion via SaveLog(), il contient uniquement des fragments sûrs (texte + <a>).
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

    // Pagination HTML (numérotée, fenêtre condensée)
    $totalPages = $perPage > 0 ? (int) ceil($total / $perPage) : 1;
    $out .= '<div class="container mt-2"><div class="d-flex justify-content-center align-items-center flex-wrap gap-1">';

    // Prev
    if ($page > 1) {
        $out .= '<button class="btn btn-outline-secondary me-2 log-page-btn" data-page="' . ($page - 1) . '">Précédent</button>';
    }

    if (!$showAll) {
        $maxButtons = 7; // nombre maximal de boutons numériques affichés
        if ($totalPages <= $maxButtons) {
            for ($p = 1; $p <= $totalPages; $p++) {
                $cls = $p == $page ? 'btn-primary' : 'btn-outline-secondary';
                $out .= '<button class="btn ' . $cls . ' log-page-btn" data-page="' . $p . '">' . $p . '</button>';
            }
        } else {
            $side = (int) floor(($maxButtons - 3) / 2); // espace autour de la page courante
            $start = max(2, $page - $side);
            $end = min($totalPages - 1, $page + $side);
            // ajuster si proche des bords
            if ($start <= 2) {
                $start = 2;
                $end = $start + ($maxButtons - 3);
            }
            if ($end >= $totalPages - 1) {
                $end = $totalPages - 1;
                $start = $end - ($maxButtons - 3);
            }

            // premier
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
        // quand show_all activé, on ne propose pas la pagination numérotée
        $out .= '<span class="text-muted">Affichage complet (' . $total . ' entrées)</span>';
    }

    // Next
    if (!$showAll && $page < $totalPages) {
        $out .= '<button class="btn btn-outline-secondary ms-2 log-page-btn" data-page="' . ($page + 1) . '">Suivant</button>';
    }

    // Bouton tout afficher / revenir
    if (!$showAll) {
        $out .= '<button class="btn btn-outline-primary ms-3 log-showall-btn" data-showall="1">Tout afficher</button>';
    } else {
        $out .= '<button class="btn btn-outline-primary ms-3 log-showall-btn" data-showall="0">Limiter l\'affichage</button>';
    }

    $out .= '</div></div>';

    echo $out;