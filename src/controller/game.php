<?php
/**
 * @author Stan Gumeniuk i@vigo.su
 */

function controller_game_index()
{
    $c = framework_template_compileTemplate('game/layout', array(
        'container' => 'Hello, world!',
        'token'     => framework_auth_getUserToken(),
    ));
    framework_response_setContent($c);
}

function controller_game_api_get_table()
{

//    $array = array(
//        '0' => array('0' => "1", '1' => "", '2' => "", '3' => "", '4' => ""),
//        '1' => array('0' => "1", '1' => "", '2' => "", '3' => "", '4' => ""),
//        '2' => array('0' => "с", '1' => "л", '2' => "о", '3' => "в", '4' => "о"),
//        '3' => array('0' => "1", '1' => "", '2' => "", '3' => "", '4' => ""),
//        '4' => array('0' => "1", '1' => "", '2' => "", '3' => "", '4' => ""),
//    );

    if (!framework_auth_checkPostRequestWithToken()) {
        controller_error_401();
    }

    $array = game_game_getUserTable();
//    framework_response_helper_setContentTypeJson();

    framework_response_helper_createJsonResponse($array);
}

function controller_game_api_user_check_word()
{

    if (!framework_auth_checkPostRequestWithToken()) {
        controller_error_401();
    }

    $requestPostData = framework_request_getPOSTData();

    if (!isset($requestPostData['word'])) {
        controller_error_500();
    }

    if (!isset($requestPostData['table'])) {
        controller_error_500();
    }
    $word = $requestPostData['word'];
    $table = $requestPostData['table'];

    $correct = false;
    if (game_game_checkUserWord($word) == FIDEOS_GAME_USER_WORD_STATUS_OK) {
        $table = game_game_addLetterToTableFromWord($word, $table);
        game_game_addWordToWordsList($word);
        $correct = true;
    }

    framework_response_helper_createJsonResponse(
        [
            'table' => $table,
            'correct' => $correct,
        ]
    );
}


function controller_game_api_comp_exec()
{

//    if (!framework_auth_checkPostRequestWithToken()) {
//        controller_error_401();
//    }

    $correct = false;

    game_game_compExec();

    framework_response_helper_createJsonResponse(
        [
            'correct' => $correct,
        ]
    );
}

function controller_game_api_user_clear()
{

    if (!framework_auth_checkPostRequestWithToken()) {
        controller_error_401();
    }

    game_game_restart();
    $table = game_game_getUserTable();

    framework_response_helper_createJsonResponse($table);
}