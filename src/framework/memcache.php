<?php
/**
 * @author Stan Gumeniuk i@vigo.su
 */

function framework_memcache_getConnection()
{
    framework_profiler_startProfileEvent(__FUNCTION__);

    static $mc = null;

    $config = framework_config_getAll();

    if (!isset($config['mc'])) {
        framework_profiler_stopProfileEvent(__FUNCTION__);
        return false;
    }

    $mcConfigs = $config['mc'];

    if (!isset($mcConfigs['dict'])) {
        framework_profiler_stopProfileEvent(__FUNCTION__);
        return false;
    }

    if (!isset($mcConfigs['dict']['host'])) {
        framework_profiler_stopProfileEvent(__FUNCTION__);
        return false;
    }

    if (!isset($mcConfigs['dict']['port'])) {
        framework_profiler_stopProfileEvent(__FUNCTION__);
        return false;
    }

    $host = $mcConfigs['dict']['host'];
    $port = $mcConfigs['dict']['port'];

    if (is_null($mc)) {
        $mc = memcache_pconnect($host, $port);
    }

    framework_profiler_stopProfileEvent(__FUNCTION__);
    return $mc;
}

function framework_memcache_set($key, $value)
{
    framework_profiler_startProfileEvent(__FUNCTION__ . '|' . $key);
    $mc = framework_memcache_getConnection();
    if (!$mc) {
        framework_profiler_stopProfileEvent(__FUNCTION__ . '|' . $key);
        return false;
    }
    $res = memcache_set($mc, $key, $value, 0, 30);
    framework_profiler_stopProfileEvent(__FUNCTION__ . '|' . $key);
    return $res;
}

function framework_memcache_get($key)
{
    framework_profiler_startProfileEvent(__FUNCTION__ . '|' . $key);
    $mc = framework_memcache_getConnection();
    if (!$mc) {
        framework_profiler_stopProfileEvent(__FUNCTION__ . '|' . $key);
        return false;
    }
    $res = memcache_get($mc, $key);
    framework_profiler_stopProfileEvent(__FUNCTION__ . '|' . $key);
    return $res;
}
