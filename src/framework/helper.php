<?php
/**
 * @author Stan Gumeniuk i@vigo.su
 */


function framework_helper_mbStrRev($string, $encoding = 'UTF8')
{
    $length = mb_strlen($string, $encoding);
    $reversed = '';
    while ($length-- > 0) {
        $reversed .= mb_substr($string, $length, 1, $encoding);
    }

    return $reversed;
}