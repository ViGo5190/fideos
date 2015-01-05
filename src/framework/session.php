<?php
/**
 * @author Stan Gumeniuk i@vigo.su
 */


const SESSION_NAME = 'fideos';

/**
 * Start session. fix problem with a lot of start session. work only on php >  5.4
 */
function framework_session_startSession()
{
    if (session_status() == PHP_SESSION_NONE) {
        session_name(SESSION_NAME);
        session_start();
    }
}

function framework_session_getAll()
{
    framework_session_startSession();

    return $_SESSION;
}

function framework_session_setData($name, $value)
{
    framework_session_startSession();

    $_SESSION[$name] = $value;
}

function framework_session_unSetData($name)
{
    framework_session_startSession();
    unset($_SESSION[$name]);
}