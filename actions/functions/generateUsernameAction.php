<?php function username($firstname, $lastname){
    $username = strtolower(substr($firstname, 0, 1) . substr($lastname, 0, 7));
        // Delete the non-leters caracters (UTF-8 compliant)
        $cleanFirst = preg_replace('/[^\p{L}\p{N}]/u', '', $firstname);
        $cleanLast  = preg_replace('/[^\p{L}\p{N}]/u', '', $lastname);

        // Take the first letter of the first name and up to 7 characters of the last name (UTF-8 compliant)
        $firstChar = mb_substr($cleanFirst, 0, 1, 'UTF-8');
        $lastPart  = mb_substr($cleanLast, 0, 7, 'UTF-8');

        // Return in lowercase (UTF-8)
        return mb_strtolower($firstChar . $lastPart, 'UTF-8');
}