<?php
/**
 * @author Stan Gumeniuk i@vigo.su
 */

const FIDEOS_GAME_USER_TABLE = 'fideos_game_user_table';
const FIDEOS_GAME_USED_WORDS = 'fideos_game_used_words';
const FIDEOS_GAME_FIND_WORDS = 'fideos_game_find_words';

const FIDEOS_GAME_USER_WORDS = 'fideos_game_user_words';
const FIDEOS_GAME_COMP_WORDS = 'fideos_game_comp_words';

const FIDEOS_GAME_STATUS_EXEC_KEY = 'fideos_game_status_exec';
const FIDEOS_GAME_STATUS_EXEC_USER = 1;
const FIDEOS_GAME_STATUS_EXEC_PC = 2;
const FIDEOS_GAME_STATUS_EXEC_END = 3;

const FIDEOS_GAME_USER_WORD_STATUS_OK = '1';
const FIDEOS_GAME_USER_WORD_STATUS_TO_SHORT = '2';
const FIDEOS_GAME_USER_WORD_STATUS_NOT_FOUND = '3';
const FIDEOS_GAME_USER_WORD_STATUS_NO_ADDED_LETTER = '4';
const FIDEOS_GAME_USER_WORD_STATUS_USED = '5';

function game_game_getUserTable()
{
    if (!isset(framework_session_getAll()[FIDEOS_GAME_USER_TABLE])) {
        framework_session_setData(FIDEOS_GAME_USER_TABLE, game_game_genTable());
    }
    return framework_session_getAll()[FIDEOS_GAME_USER_TABLE];
}

function game_game_setUserTable($table)
{
    framework_session_setData(FIDEOS_GAME_USER_TABLE, $table);
}

function game_game_getUsedWords()
{
    if (!isset(framework_session_getAll()[FIDEOS_GAME_USED_WORDS])) {
        framework_session_setData(FIDEOS_GAME_USED_WORDS, []);
    }
    return framework_session_getAll()[FIDEOS_GAME_USED_WORDS];
}

function game_game_setUsedWords($words)
{
    framework_session_setData(FIDEOS_GAME_USED_WORDS, $words);
}

function game_game_clearUsedWords()
{
    framework_session_setData(FIDEOS_GAME_USED_WORDS, []);
}


function game_game_getUserWords()
{
    if (!isset(framework_session_getAll()[FIDEOS_GAME_USER_WORDS])) {
        framework_session_setData(FIDEOS_GAME_USER_WORDS, []);
    }
    return framework_session_getAll()[FIDEOS_GAME_USER_WORDS];
}

function game_game_setUserWords($words)
{
    framework_session_setData(FIDEOS_GAME_USER_WORDS, $words);
}

function game_game_clearUserWords()
{
    framework_session_setData(FIDEOS_GAME_USER_WORDS, []);
}

function game_game_getStatusExec()
{
    if (!isset(framework_session_getAll()[FIDEOS_GAME_STATUS_EXEC_KEY])) {
        framework_session_setData(FIDEOS_GAME_STATUS_EXEC_KEY, FIDEOS_GAME_STATUS_EXEC_USER);
    }
    return framework_session_getAll()[FIDEOS_GAME_STATUS_EXEC_KEY];
}

function game_game_setStatusExec($status)
{
    framework_session_setData(FIDEOS_GAME_STATUS_EXEC_KEY, $status);
}

function game_game_clearStatusExec()
{
    framework_session_setData(FIDEOS_GAME_STATUS_EXEC_KEY, FIDEOS_GAME_STATUS_EXEC_USER);
}



function game_game_getCompWords()
{
    if (!isset(framework_session_getAll()[FIDEOS_GAME_COMP_WORDS])) {
        framework_session_setData(FIDEOS_GAME_COMP_WORDS, []);
    }
    return framework_session_getAll()[FIDEOS_GAME_COMP_WORDS];
}

function game_game_setCompWords($words)
{
    framework_session_setData(FIDEOS_GAME_COMP_WORDS, $words);
}

function game_game_clearCompWords()
{
    framework_session_setData(FIDEOS_GAME_COMP_WORDS, []);
}

function game_game_getFindWords()
{
    if (!isset(framework_session_getAll()[FIDEOS_GAME_FIND_WORDS])) {
        framework_session_setData(FIDEOS_GAME_FIND_WORDS, []);
    }
    return framework_session_getAll()[FIDEOS_GAME_FIND_WORDS];
}

function game_game_setFindWords($words)
{
    framework_session_setData(FIDEOS_GAME_FIND_WORDS, $words);
}

function game_game_clearFindWords()
{
    framework_session_setData(FIDEOS_GAME_FIND_WORDS, []);
}

function game_game_genTable()
{
    framework_profiler_startProfileEvent('game_gen_table');
    game_game_addWordToWordsList("балда");
    $array = array(
        '0' => array(
            '0' => array('letter' => "", 'used' => 1),
            '1' => array('letter' => "", 'used' => 1),
            '2' => array('letter' => "", 'used' => 1),
            '3' => array('letter' => "", 'used' => 1),
            '4' => array('letter' => "", 'used' => 1)
        ),
        '1' => array(
            '0' => array('letter' => "", 'used' => 1),
            '1' => array('letter' => "", 'used' => 1),
            '2' => array('letter' => "", 'used' => 1),
            '3' => array('letter' => "", 'used' => 1),
            '4' => array('letter' => "", 'used' => 1)
        ),
        '2' => array(
            '0' => array('letter' => "б", 'used' => 1),
            '1' => array('letter' => "а", 'used' => 1),
            '2' => array('letter' => "л", 'used' => 1),
            '3' => array('letter' => "д", 'used' => 1),
            '4' => array('letter' => "а", 'used' => 1)
        ),
        '3' => array(
            '0' => array('letter' => "", 'used' => 1),
            '1' => array('letter' => "", 'used' => 1),
            '2' => array('letter' => "", 'used' => 1),
            '3' => array('letter' => "", 'used' => 1),
            '4' => array('letter' => "", 'used' => 1)
        ),
        '4' => array(
            '0' => array('letter' => "", 'used' => 1),
            '1' => array('letter' => "", 'used' => 1),
            '2' => array('letter' => "", 'used' => 1),
            '3' => array('letter' => "", 'used' => 1),
            '4' => array('letter' => "", 'used' => 1)
        ),
    );

    framework_profiler_stopProfileEvent('game_gen_table');

    return $array;
}

function game_game_compExec()
{
    framework_profiler_startProfileEvent('compExec');
    game_game_clearFindWords();
    $table = game_game_getUserTable();
    $words = [];

    for ($x = 0; $x < 5; $x++) {
        for ($y = 0; $y < 5; $y++) {

            if ((game_game_isNearestCellFilled($x, $y)) && ($table[$x][$y]['letter'] == "")) {

                $table = game_game_getUserTable();
                $words = [];
                foreach (game_word_getAlphabet() as $letter) {
                    $table[$x][$y]['letter'] = $letter;
                    $table[$x][$y]['used'] = 0;
                    $mckey = TREE_REVERT_POSTFIX_KEY;
                    $n = framework_memcache_get($mckey . $letter);

                    game_word_checkRevertPostFixFoo($table, $x, $y, $n, $words, $x, $y, $letter);
                }
            }
        }
    }
    $words = game_game_getFindWords();

    $maxLength = 0;
    $bestWrd = null;
    foreach ($words as $word) {
        if ((mb_strlen($word['wrd']) > $maxLength) && (!game_game_checkWordInUsedWords($word['wrd']))) {
            $bestWrd = $word;
            $maxLength = mb_strlen($word['wrd']);
        }
    }
    game_game_clearFindWords();
    framework_profiler_stopProfileEvent('compExec');

    if ($bestWrd) {
        game_game_addLetterToTableFromWord($bestWrd['x'], $bestWrd['y'], $bestWrd['letter']);
        $compWords = game_game_getCompWords();
        $compWords[] = $bestWrd['wrd'];
        game_game_setCompWords($compWords);

        game_game_addWordToWordsList($bestWrd['wrd']);

        game_game_setStatusExec(FIDEOS_GAME_STATUS_EXEC_USER);
        return $bestWrd['wrd'];
    }
    game_game_setStatusExec(FIDEOS_GAME_STATUS_EXEC_END);
    return false;
}

/**
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


    $wordStr = game_game_wordArrayToStr($word);

    if (game_game_checkWordInUsedWords($wordStr)) {
        framework_profiler_stopProfileEvent('game_game_checkUserWord');
        return FIDEOS_GAME_USER_WORD_STATUS_USED;
    }

    $status = game_word_checkWordUser($wordStr);
    if (!$status) {
        framework_profiler_stopProfileEvent('game_game_checkUserWord');
        return FIDEOS_GAME_USER_WORD_STATUS_NOT_FOUND;
    }

    game_game_addLetterFromUserWordToTableFromWord($word, game_game_getUserTable());
    game_game_addWordToWordsList($word);

    $userWords = game_game_getUserWords();
    $userWords[] = $wordStr;
    game_game_setUserWords($userWords);

    framework_profiler_stopProfileEvent('game_game_checkUserWord');
    return FIDEOS_GAME_USER_WORD_STATUS_OK;
}

function game_game_wordArrayToStr($word)
{
    $s = '';
    foreach ($word as $letter) {
        $s .= $letter['val'];
    }
    return $s;
}

function game_game_addLetterFromUserWordToTableFromWord($word, $table)
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

    game_game_setUserTable($table);
    return $table;
}

function game_game_addLetterToTableFromWord($x, $y, $letter)
{
    $table = game_game_getUserTable();
    $table[$x][$y]['letter'] = $letter;

    game_game_setUserTable($table);

    return $table;
}

function game_game_restart()
{
    game_game_clearStatusExec();
    game_game_clearUserWords();
    game_game_clearCompWords();
    game_game_clearUsedWords(FIDEOS_GAME_USED_WORDS, []);

    framework_session_setData(FIDEOS_GAME_USER_TABLE, game_game_genTable());
}

function game_game_addWordToWordsList($word)
{
    if (is_array($word)) {
        $word = game_game_wordArrayToStr($word);
    }

    $words = game_game_getUsedWords();

    $words[] = $word;
    game_game_setUsedWords($words);
}

function game_game_checkWordInUsedWords($word)
{
    $words = game_game_getUsedWords();
    if (in_array($word, $words)) {
        return true;
    }
    return false;
}

function game_game_isNearestCellFilled($x, $y)
{
    $table = game_game_getUserTable();
    if (isset($table[$x - 1]) && ($table[$x - 1][$y]['letter'] != "")) {
        return true;
    }

    if (isset($table[$x + 1]) && ($table[$x + 1][$y]['letter'] != "")) {
        return true;
    }

    if (isset($table[$x][$y - 1]) && ($table[$x][$y - 1]['letter'] != "")) {
        return true;
    }

    if (isset($table[$x][$y + 1]) && ($table[$x][$y + 1]['letter'] != "")) {
        return true;
    }
    return false;
}



