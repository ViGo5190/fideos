<?php
/**
 * @author Stan Gumeniuk i@vigo.su
 */

if (!defined('FIDEOS_PROFILER_ENABLED')) {
    define('FIDEOS_PROFILER_ENABLED', false);
}

define('FIDEOS_PROFILER_ENV_PREFIX', '_profiler_');
define('FIDEOS_PROFILER_EVENT_LIST_ENV_PREFIX', '_profiler_event_list_');

$_ENV[FIDEOS_PROFILER_ENV_PREFIX] = array();
$_ENV[FIDEOS_PROFILER_EVENT_LIST_ENV_PREFIX] = array();

function framework_profiler_startProfileEvent($eventName)
{

    if (!FIDEOS_PROFILER_ENABLED) {
        return false;
    }

    $_ENV[FIDEOS_PROFILER_ENV_PREFIX][$eventName]['time'] = microtime(true);
    $_ENV[FIDEOS_PROFILER_ENV_PREFIX][$eventName]['memory'] = memory_get_usage(true);

    $_ENV[FIDEOS_PROFILER_EVENT_LIST_ENV_PREFIX][] = $eventName;
}

function framework_profiler_stopProfileEvent($eventName)
{
    if (!FIDEOS_PROFILER_ENABLED) {
        return false;
    }

    $startTime = $_ENV[FIDEOS_PROFILER_ENV_PREFIX][$eventName]['time'];
    $_ENV[FIDEOS_PROFILER_ENV_PREFIX][$eventName]['timeTotal'] = round((microtime(true) - $startTime) * 1000, 0);
    $startMemory = $_ENV[FIDEOS_PROFILER_ENV_PREFIX][$eventName]['memory'];
    $_ENV[FIDEOS_PROFILER_ENV_PREFIX][$eventName]['memoryTotal'] = memory_get_usage(true) - $startMemory;
}

function framework_profiler_getProfileData()
{

    $profilerData = $_ENV[FIDEOS_PROFILER_ENV_PREFIX];
    return $profilerData;
}

function framework_profiler_getProfileDataHtml()
{
    $r = '<pre>';
    $r .= print_r(framework_profiler_getProfileData(), true);
    $r .= '</pre>';
    return $r;
}

function framework_profiler_clean()
{
    $_ENV[FIDEOS_PROFILER_ENV_PREFIX] = array();
}