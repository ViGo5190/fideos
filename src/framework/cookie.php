<?php
/**
 * @author Stan Gumeniuk i@vigo.su
 */


const COOKIE_LIFE_TIME = 2592000;

function framework_cookie_getAll()
{
    return $_COOKIE;
}

function framework_cookie_getByName($name)
{
    if (isset($_COOKIE[$name])) {
        return $_COOKIE[$name];
    }
    return false;
}

function framework_cookie_setCookie($name, $value, $cookieLifeTime = COOKIE_LIFE_TIME)
{
    return setcookie($name, $value, time() + $cookieLifeTime);
}