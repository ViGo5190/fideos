<?php
/**
 * @author Stan Gumeniuk i@vigo.su
 */

define('FIDEOS_PROFILER_ENABLED', true);

error_reporting(E_ALL);
ini_set('display_errors', 1);
ini_set('memory_limit', '2048M');

mb_internal_encoding("UTF-8");

require_once '../src/loader.php';

framework_profiler_startProfileEvent('parse');

$filename = "dict1.txt";

static $iiii = 1;

if (file_exists($filename)) {
    $file_handle = fopen($filename, "r");
    while (!feof($file_handle)) {

        echo $iiii++ . "\n";

        $line = fgets($file_handle);
        game_word_wordAdd($line);
//        game_word_wordAdd('издатель');
//        break;
        game_word_wordAddRevertPostFix($line);
        unset($line);
    }
    fclose($file_handle);
}

framework_profiler_stopProfileEvent('parse');

framework_profiler_startProfileEvent('parse_check');
$err = 0;

if (file_exists($filename)) {
    $file_handle = fopen($filename, "r");
    while (!feof($file_handle)) {


        $line = fgets($file_handle);
        $r = game_word_checkWordUser($line);
        if (!$r){
            $err++;
        }

        unset($line);
    }
    fclose($file_handle);
}

echo 'Not found:' . $err .PHP_EOL;
framework_profiler_stopProfileEvent('parse_check');


echo "\n\n -------PROFILER------- \n\n";
var_dump(framework_profiler_getProfileDataByKey('parse'));
var_dump(framework_profiler_getProfileDataByKey('parse_check'));
framework_profiler_clean();

