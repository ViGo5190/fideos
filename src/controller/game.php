<?php
/**
 * @author Stan Gumeniuk i@vigo.su
 */

function controller_game_index()
{
    $c = framework_template_compileTemplate('game/layout', array(
        'container' => 'Hello, world!',
        'token'     => framework_auth_getUserToken(),
        'userwords' => array_reverse(game_game_getUserWords()),
        'compwords' => array_reverse(game_game_getCompWords()),
    ));
    framework_response_setContent($c);
}

function controller_game_api_get_table()
{

    if (!framework_auth_checkPostRequestWithToken()) {
        controller_error_401();
    }

    $array = game_game_getUserTable();

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

    if (game_game_getStatusExec()!=FIDEOS_GAME_STATUS_EXEC_USER){
        controller_error_500();
    }
    $word = $requestPostData['word'];
    $table = $requestPostData['table'];

    $correct = false;
    $wordStr = null;
    if (game_game_checkUserWord($word) == FIDEOS_GAME_USER_WORD_STATUS_OK) {
        $table = game_game_addLetterFromUserWordToTableFromWord($word, $table);
        $correct = true;
        $wordStr = game_game_wordArrayToStr($word);
        game_game_setStatusExec(FIDEOS_GAME_STATUS_EXEC_PC);
    }

    framework_response_helper_createJsonResponse(
        [
            'table'   => $table,
            'correct' => $correct,
            'word'    => $wordStr,
        ]
    );
}

function controller_game_api_comp_exec()
{

    if (!framework_auth_checkPostRequestWithToken()) {
        controller_error_401();
    }

    if (game_game_getStatusExec()!=FIDEOS_GAME_STATUS_EXEC_PC){
        controller_error_500('Not PC exec now!');
    }

    $correct = game_game_compExec();
    $table = game_game_getUserTable();
    framework_response_helper_createJsonResponse(
        [
            'correct' => $correct == false ? false : true,
            'table'   => $table,
            'word'    => $correct == false ? null : $correct,
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