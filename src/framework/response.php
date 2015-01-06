<?php
/**
 * @author Stan Gumeniuk i@vigo.su
 */


$_ENV['_response_'] = array(
    'content' => ''
);

function framework_response_setContent($content = ''){
    $_ENV['_response_']['content'] = $content;
}


function framework_response_send()
{
    echo $_ENV['_response_']['content'];
}
