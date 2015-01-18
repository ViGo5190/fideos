<?php
/**
 * @author Stan Gumeniuk i@vigo.su
 */

require_once __DIR__ . '/controller/error.php';
require_once __DIR__ . '/controller/page.php';
require_once __DIR__ . '/controller/game.php';

require_once __DIR__ . '/framework/config.php';
require_once __DIR__ . '/framework/profiler.php';
require_once __DIR__ . '/framework/router.php';
require_once __DIR__ . '/framework/request.php';
require_once __DIR__ . '/framework/session.php';
require_once __DIR__ . '/framework/template.php';
require_once __DIR__ . '/framework/response.php';
require_once __DIR__ . '/framework/auth.php';
require_once __DIR__ . '/framework/memcache.php';
require_once __DIR__ . '/framework/helper.php';

require_once __DIR__ . '/game/game.php';
require_once __DIR__ . '/game/word.php';
