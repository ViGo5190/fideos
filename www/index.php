<?php
/**
 * @author Stan Gumeniuk i@vigo.su
 * @author sgumeniuk@topface.com
 * Date: 05/01/15
 * Time: 19:23
 */

$startTime = microtime(true);

define('FIDEOS_PROFILER_ENABLED', true);

error_reporting(E_ALL);
ini_set('display_errors', 1);

require_once '../src/loader.php';

framework_session_startSession();

framework_router_run();

framework_response_send();

framework_profiler_clean();