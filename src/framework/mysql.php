<?php
/**
 * @author Stan Gumeniuk i@vigo.su
 */


function framework_myqsl_getConnection($name)
{
    static $connections = [];

    if (isset($connections[$name])) {
        return $connections[$name];
    }

    $config = configGetAll();

    if (!isset($config['dbs'][$name])) {
        die('DB ' . $name . ' config not find!');
    }

    $config = $config['dbs'][$name];

    $mysqli = mysqli_connect($config['host'], $config['user'], $config['password'], $config['db']);
    if (mysqli_connect_errno($mysqli)) {
        die('Cannot connect to db:' . $name);
    }

    $connections[$name] = $mysqli;

    return $connections[$name];
}