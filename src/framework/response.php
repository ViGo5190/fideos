<?php
/**
 * @author Stan Gumeniuk i@vigo.su
 */


$_ENV['_response_'] = array(
    'content' => '',
    'headers' => array(),
);

function framework_response_setContent($content = ''){
    $_ENV['_response_']['content'] = $content;
}

function framework_response_addHeaders($header = ''){
    $_ENV['_response_']['headers'][] = $header;
}


function framework_response_send()
{
    if (count($_ENV['_response_']['headers'])>0)
    {
        foreach ( $_ENV['_response_']['headers'] as $header){
            header($header);
        }
    }
    echo $_ENV['_response_']['content'];
}



function framework_response_helper_setContentTypeJson()
{
    framework_response_addHeaders('Content-Type: application/json');
}