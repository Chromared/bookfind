<?php
function username($firstname, $lastname) {
    $clean = function($s) {
        $s = (string)$s;
        if (class_exists('Normalizer')) {
            $s = Normalizer::normalize($s, Normalizer::FORM_D);
            $s = preg_replace('/\p{M}/u', '', $s);
        } else {
            $s = @iconv('UTF-8', 'ASCII//TRANSLIT//IGNORE', $s) ?: $s;
        }
        $s = strtr($s, ['œ'=>'oe','Œ'=>'OE','æ'=>'ae','Æ'=>'AE','ç'=>'c','Ç'=>'C']);
        return preg_replace('/[^\p{L}\p{N}]/u', '', $s);
    };

    $first = $clean($firstname);
    $last  = $clean($lastname);
    return mb_strtolower(mb_substr($first, 0, 1, 'UTF-8') . mb_substr($last, 0, 7, 'UTF-8'), 'UTF-8');
}