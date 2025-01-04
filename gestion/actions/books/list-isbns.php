<?php
//This file belongs to the Bookfind project.
//
//Bookfind is distributed under the terms of the MIT software license.
//
//Copyright (C) 2024 Chromared
?>

<?php $selectISBNs= $bdd->query('SELECT DISTINCT isbn FROM books');

    //if(isset($['isbn'])){
        //while($isbns = $selectISBNs->fetch()){
            //echo '<option value="' . $isbns['isbn'] . '" ' . SelectedWithoutEcho($isbns['isbn'], $['isbn']) . '>' . $isbns['isbn'] . '</option>';
        //}
    //}else{

    while($isbns = $selectISBNs->fetch()){
        echo '<option value="' . $isbns['isbn'] . '">' . $isbns['isbn'] . '</option>';
    }//}