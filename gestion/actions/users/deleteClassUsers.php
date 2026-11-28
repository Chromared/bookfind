<?php
require_once ROOT_PATH . '/actions/users/deleteUsersPreservingLoans.php';

if (isset($_POST['classUsersDeletePreview'])) {
    $className = isset($_POST['classToDelete']) && is_string($_POST['classToDelete'])
        ? trim($_POST['classToDelete'])
        : '';
    $checkClass = $db->prepare('SELECT name FROM classes WHERE name = ?');
    $checkClass->execute([$className]);

    if ($className === '' || $checkClass->fetchColumn() === false) {
        $msgClassUsers = bookfind_translate('Please select a valid class.');
    } else {
        $countUsers = $db->prepare('SELECT COUNT(*) FROM users WHERE class_name = ?');
        $countUsers->execute([$className]);
        $userCount = (int)$countUsers->fetchColumn();

        if ($userCount === 0) {
            $msgClassUsers = bookfind_translate('There are no users in this class.');
        } else {
            $classUsersDeletionPreview = ['name' => $className, 'count' => $userCount];
        }
    }
}

if (isset($_POST['classUsersDeleteConfirm'])) {
    $className = isset($_POST['classToDelete']) && is_string($_POST['classToDelete'])
        ? trim($_POST['classToDelete'])
        : '';
    $db->beginTransaction();

    try {
        $checkClass = $db->prepare('SELECT name FROM classes WHERE name = ? FOR UPDATE');
        $checkClass->execute([$className]);
        if ($checkClass->fetchColumn() === false) {
            $db->rollBack();
            $msgClassUsers = bookfind_translate('Please select a valid class.');
        } else {
            $selectUsers = $db->prepare('SELECT id FROM users WHERE class_name = ? FOR UPDATE');
            $selectUsers->execute([$className]);
            $userIds = array_map('intval', $selectUsers->fetchAll(PDO::FETCH_COLUMN));

            $expectedCount = filter_var($_POST['expectedUserCount'] ?? null, FILTER_VALIDATE_INT);
            if ($expectedCount === false || $expectedCount !== count($userIds)) {
                $db->rollBack();
                if ($userIds === []) {
                    $msgClassUsers = bookfind_translate('There are no users in this class.');
                } else {
                    $classUsersDeletionPreview = ['name' => $className, 'count' => count($userIds)];
                }
            } else {
                $deletedCount = deleteUsersPreservingLoans($db, $userIds);

                SaveLog(
                    $db,
                    $_SERVER['REQUEST_URI'],
                    'Class users deleted',
                    sprintf('%d user account(s) in class "%s" were deleted; loan history was retained.', $deletedCount, htmlspecialchars($className, ENT_QUOTES, 'UTF-8'))
                );

                $db->commit();
                header('Location: ' . url('gestion/bookfind.php?tab=classes&successDeleteClassUsers=' . $deletedCount . '#deleteClassUsers'));
                exit;
            }
        }
    } catch (Throwable $exception) {
        if ($db->inTransaction()) {
            $db->rollBack();
        }
        throw $exception;
    }
}
