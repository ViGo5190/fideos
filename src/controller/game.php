<?php
/**
 * @author Stan Gumeniuk i@vigo.su
 */

function controller_game_index()
{
    $c = framework_template_compileTemplate('game/layout', array(
        'container' => 'Hello, world!',
    ));
    framework_response_setContent($c);
}


function controller_game_api_get_table(){


    $array = array(
        '1' => array('1' => "1", '2' => "", '3' => "", '4' => "", '5' => ""),
        '2' => array('1' => "", '2' => "", '3' => "", '4' => "", '5' => ""),
        '3' => array('1' => "с", '2' => "л", '3' => "о", '4' => "в", '5' => "о"),
        '4' => array('1' => "", '2' => "", '3' => "", '4' => "", '5' => ""),
        '5' => array('1' => "", '2' => "", '3' => "", '4' => "", '5' => ""),
    );

    framework_response_helper_setContentTypeJson();

    framework_response_setContent(json_encode($array));
}