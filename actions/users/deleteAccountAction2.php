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



<?php if (isset($_POST['validateDelete2'])) {

        $checkPassword = $db->prepare('DELETE FROM users WHERE id = ?');
        $checkPassword->execute(array($id));

        SaveLog($db, $_SERVER['REQUEST_URI'], 'Account deleted', 'No comment.');

        header('Location: ' . url('actions/users/logoutAction.php'));
}
