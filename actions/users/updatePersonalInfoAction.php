<?php
//This file belongs to the BookFind project.
//
//BookFind is distributed under the terms of the GNU Affero General Public License v3.0.
//
//Copyright (C) 2025 Chromared
?>



<?php
if (isset($_POST['validatePersonalInfo'])) {
        if (isset($_POST['name']) AND isset($_POST['firstname'])) {
        if (!empty($_POST['name']) AND !empty($_POST['firstname'])) {
            $name = $_POST['name'];
            $firstname = $_POST['firstname'];
            $id = $_SESSION['id'];

            $updatePersonalInfo = $db->prepare('UPDATE users SET last_name = ?, first_name = ? WHERE id = ?');
            $updatePersonalInfo->execute(array($name, $firstname, $id));

            if($name != $_SESSION['lastname'] AND $firstname == $_SESSION['firstname']){
                SaveLog($db, $_SERVER['REQUEST_URI'], 'Account modified', 'The new last name is ' . $name . '.');
            }elseif($name == $_SESSION['lastname'] AND $firstname != $_SESSION['firstname']){
                SaveLog($db, $_SERVER['REQUEST_URI'], 'Account modified', 'The new first name is ' . $firstname . '.');
            }elseif($name != $_SESSION['lastname'] AND $firstname != $_SESSION['firstname']){
                SaveLog($db, $_SERVER['REQUEST_URI'], 'Account modified', 'This user is now named ' . $name . ' ' . $firstname . '.');
            }

            $_SESSION['lastname'] = $name;
            $_SESSION['firstname'] = $firstname;

            header('Location: updateProfile.php?id=' . $id .'&msg1=true');

    }else {
        $errorMsg1 = 'Please fill in all fields.';
    }
}else{
    $errorMsg1 = 'Not all fields exist. Please <a href="updateProfile.php?id=' . $id . '">reload</a> the page.';
}
}