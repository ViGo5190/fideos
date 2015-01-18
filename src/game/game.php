<?php
/**
 * @author Stan Gumeniuk i@vigo.su
 */

const FIDEOS_GAME_USER_TABLE = 'fideos_game_user_table';

const FIDEOS_GAME_USER_WORD_STATUS_OK = '1';
const FIDEOS_GAME_USER_WORD_STATUS_TO_SHORT = '2';
const FIDEOS_GAME_USER_WORD_STATUS_NOT_FOUND = '3';
const FIDEOS_GAME_USER_WORD_STATUS_NO_ADDED_LETTER = '4';

function game_game_getUserTable()
{
    if (!isset(framework_session_getAll()[FIDEOS_GAME_USER_TABLE])) {
        framework_session_setData(FIDEOS_GAME_USER_TABLE, game_game_genTable());
    }
    return framework_session_getAll()[FIDEOS_GAME_USER_TABLE];
}

function game_game_genTable()
{
    framework_profiler_startProfileEvent('game_gen_table');
    $array = array(
        '0' => array(
            '0' => array('letter' => "1"),
            '1' => array('letter' => ""),
            '2' => array('letter' => ""),
            '3' => array('letter' => ""),
            '4' => array('letter' => "")
        ),
        '1' => array(
            '0' => array('letter' => "1"),
            '1' => array('letter' => ""),
            '2' => array('letter' => ""),
            '3' => array('letter' => ""),
            '4' => array('letter' => "")
        ),
        '2' => array(
            '0' => array('letter' => "с"),
            '1' => array('letter' => "л"),
            '2' => array('letter' => "о"),
            '3' => array('letter' => "в"),
            '4' => array('letter' => "о")
        ),
        '3' => array(
            '0' => array('letter' => "1"),
            '1' => array('letter' => ""),
            '2' => array('letter' => ""),
            '3' => array('letter' => ""),
            '4' => array('letter' => "")
        ),
        '4' => array(
            '0' => array('letter' => "1"),
            '1' => array('letter' => ""),
            '2' => array('letter' => ""),
            '3' => array('letter' => ""),
            '4' => array('letter' => "")
        ),
    );

    framework_profiler_stopProfileEvent('game_gen_table');

    return $array;
}

/**
 * FIXME
 * @param $word
 * @return string
 */
function game_game_checkUserWord($word)
{
    framework_profiler_startProfileEvent('game_game_checkUserWord');

    if (count($word) < 3) {
        framework_profiler_stopProfileEvent('game_game_checkUserWord');
        return FIDEOS_GAME_USER_WORD_STATUS_TO_SHORT;
    }

    //check word!

//    var_dump($word);die();


    $wordStr =game_game_wordArrayToStr($word);
    if (!$wordStr){
  //
    }

    $status = game_word_checkWordUser($wordStr);
    if (!$status){
        framework_profiler_stopProfileEvent('game_game_checkUserWord');
        return FIDEOS_GAME_USER_WORD_STATUS_NOT_FOUND;
    }

    game_game_addLetterToTableFromWord($word,game_game_getUserTable());

    framework_profiler_stopProfileEvent('game_game_checkUserWord');
    return FIDEOS_GAME_USER_WORD_STATUS_OK;
}


function game_game_wordArrayToStr($word){
    $s = '';
    foreach ($word as $letter){
        $s .= $letter['val'];
    }
    return $s;
}

function game_game_addLetterToTableFromWord($word, $table)
{
    $letterAdded = null;
    foreach ($word as $k => $letter) {
        if ($letter['status'] == 'pressed') {
            $letterAdded = $letter;
        }
    }

    if ($letterAdded) {
        $table[$letterAdded['x']][$letterAdded['y']]['letter'] = $letterAdded['val'];
    }

    framework_session_setData(FIDEOS_GAME_USER_TABLE, $table);

    return $table;
}

function game_game_restart()
{
    framework_session_setData(FIDEOS_GAME_USER_TABLE, game_game_genTable());
}

