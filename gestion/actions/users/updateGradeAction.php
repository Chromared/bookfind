<?php
//This file belongs to the BookFind project.
//
//BookFind is distributed under the terms of the GNU Affero General Public License v3.0.
//
//Copyright (C) 2025 Chromared
?>



<?php require_once __DIR__ . '/../../../actions/functions/sessionInit.php';
$id = $_GET['id'] ?? null;
if (isset($_POST['validateGrade'])) {
    if ($_SESSION['grade'] == '1' or $_SESSION['grade'] == '2') {
        if (isset($_POST['grade'])) {
            if (!empty($_POST['grade']) or $_POST['grade'] == 0) {

                if (($_POST['grade'] == 1 and $_SESSION['grade'] == 1) or $_POST['grade'] != 1) {

                    $newGrade = $_POST['grade'];
                    $id = $_GET['id'];

                    $updateSchoolInfo = $db->prepare('UPDATE users SET grade = ? WHERE id = ?');
                    $updateSchoolInfo->execute(array($newGrade, $id));

                    // Retrieve user info for logging
                    $getUser = $db->prepare('SELECT id, first_name, last_name, grade FROM users WHERE id = ?');
                    $getUser->execute(array($id));
                    $usersInfos = $getUser->fetch();

                    SaveLog($db, $_SERVER['REQUEST_URI'], 'Grade changed', 'The grade of <a href="../profile.php?id=' . ($usersInfos['id'] ?? '') . '">' . htmlspecialchars($usersInfos['first_name'] ?? '') . ' ' . htmlspecialchars($usersInfos['last_name'] ?? '') . '</a> was changed from ' . NoEchoGrade($usersInfos['grade'] ?? '') . ' to ' . NoEchoGrade($newGrade) . '.');

                    header('Location: update-user.php?id=' . ($id ?? '') . '&msg5=true');
                } else {
                    $errorMsg5 = 'You do not have sufficient permissions to apply this grade.';
                }
            } else {
                $errorMsg5 = 'Please fill in all fields.';
            }
        } else {
            $errorMsg5 = 'Not all fields exist. Please <a href="update-user.php?id=' . $id . '">reload</a> the page.';
        }
    } else {
        $errorMsg5 = 'You do not have permission to perform this action.';
    }
}
