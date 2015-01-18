<?php
/**
 * @author Stan Gumeniuk i@vigo.su
 */

const FIDEOS_MC_PREFIX = "fideos|";

function framework_memcache_getConnection()
{
//    framework_profiler_startProfileEvent(__FUNCTION__);

    static $mc = null;

    if (!is_null($mc)) {
        return $mc;
    }

    $config = framework_config_getAll();

    if (!isset($config['mc'])) {
//        framework_profiler_stopProfileEvent(__FUNCTION__);
        return false;
    }

    $mcConfigs = $config['mc'];

    if (!isset($mcConfigs['dict'])) {
//        framework_profiler_stopProfileEvent(__FUNCTION__);
        return false;
    }

    if (!isset($mcConfigs['dict']['host'])) {
//        framework_profiler_stopProfileEvent(__FUNCTION__);
        return false;
    }

    if (!isset($mcConfigs['dict']['port'])) {
//        framework_profiler_stopProfileEvent(__FUNCTION__);
        return false;
    }

    $host = $mcConfigs['dict']['host'];
    $port = $mcConfigs['dict']['port'];


        $mc = memcache_pconnect($host, $port);

//    framework_profiler_stopProfileEvent(__FUNCTION__);
    return $mc;
}

function framework_memcache_set($key, $value,$time=0)
{
//    framework_profiler_startProfileEvent(__FUNCTION__ . '|' . $key);
    $mc = framework_memcache_getConnection();
    if (!$mc) {
//        framework_profiler_stopProfileEvent(__FUNCTION__ . '|' . $key);
        return false;
    }
    $res = memcache_set(
        $mc,
        framework_memcache_getKeyWithPrefix($key),
        $value,
        0,
        $time);
//    framework_profiler_stopProfileEvent(__FUNCTION__ . '|' . $key);
    return $res;
}

function framework_memcache_get($key)
{
//    framework_profiler_startProfileEvent(__FUNCTION__ . '|' . $key);
    $mc = framework_memcache_getConnection();
    if (!$mc) {
//        framework_profiler_stopProfileEvent(__FUNCTION__ . '|' . $key);
        return false;
    }
    $res = memcache_get(
        $mc,
        framework_memcache_getKeyWithPrefix($key)
    );
//    framework_profiler_stopProfileEvent(__FUNCTION__ . '|' . $key);
    return $res;
}

function framework_memcache_getKeyWithPrefix($key)
{
//    echo '>>>' . FIDEOS_MC_PREFIX . $key . '<<<';
    return FIDEOS_MC_PREFIX . $key;
}
