<?php
require_once __DIR__ . '/../../../actions/functions/sessionInit.php';

if (isset($_POST['regenUsernames'])) {
    $transactionStarted = false;

    try {
        $db->beginTransaction();
        $transactionStarted = true;

        $users = $db->query('SELECT id, username, last_name, first_name FROM users ORDER BY id')->fetchAll(PDO::FETCH_ASSOC);
        $existingUsernames = [];
        foreach ($users as $user) {
            $existingUsernames[mb_strtolower($user['username'], 'UTF-8')] = true;
        }

        $reservedUsernames = [];
        $assignments = [];
        foreach ($users as $user) {
            $baseUsername = username($user['first_name'], $user['last_name']);
            if ($baseUsername === '') {
                $baseUsername = 'user' . $user['id'];
            }

            $newUsername = mb_substr($baseUsername, 0, 10, 'UTF-8');
            $suffix = 1;
            while (isset($reservedUsernames[mb_strtolower($newUsername, 'UTF-8')])) {
                $suffixText = (string)$suffix++;
                $newUsername = mb_substr($baseUsername, 0, 10 - strlen($suffixText), 'UTF-8') . $suffixText;
            }

            $newKey = mb_strtolower($newUsername, 'UTF-8');
            $reservedUsernames[$newKey] = true;
            $assignments[] = ['id' => $user['id'], 'username' => $newUsername];
        }

        // Free every existing unique value first so swaps and repeated names can be applied safely.
        $setUsername = $db->prepare('UPDATE users SET username = ? WHERE id = ?');
        $temporaryUsernames = $existingUsernames + $reservedUsernames;
        foreach ($assignments as $assignment) {
            do {
                $temporaryUsername = 'tmp' . substr(bin2hex(random_bytes(4)), 0, 7);
                $temporaryKey = strtolower($temporaryUsername);
            } while (isset($temporaryUsernames[$temporaryKey]));

            $temporaryUsernames[$temporaryKey] = true;
            $setUsername->execute([$temporaryUsername, $assignment['id']]);
        }

        foreach ($assignments as $assignment) {
            $setUsername->execute([$assignment['username'], $assignment['id']]);
        }

        $userCount = count($assignments);
        $db->commit();
        $transactionStarted = false;

        try {
            SaveLog($db, $_SERVER['REQUEST_URI'], 'Username regeneration', sprintf('Regenerated usernames for %d users.', $userCount));
        } catch (Throwable $logException) {
            error_log('Username regeneration succeeded, but logging failed: ' . $logException->getMessage());
        }
        $msgRegenUsernames = sprintf(_('Regenerated usernames for %d users.'), $userCount);
    } catch (Throwable $exception) {
        if ($transactionStarted && $db->inTransaction()) {
            $db->rollBack();
        }
        error_log('Username regeneration failed: ' . $exception->getMessage());
        $msgRegenUsernames = _('Username regeneration failed. No usernames were changed.');
        $regenUsernamesSuccess = false;
    }
}
