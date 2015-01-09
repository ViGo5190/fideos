<?php
/**
 * @author Stan Gumeniuk i@vigo.su
 */

const FIDEOS_AUTH_SESSION_INITED = 'fideos_auth_inited';
const FIDEOS_AUTH_SESSION_TOKEN = 'fideos_auth_token';

function framework_auth_auth()
{
    if (!isset(framework_session_getAll()[FIDEOS_AUTH_SESSION_INITED])) {
        framework_session_setData(FIDEOS_AUTH_SESSION_INITED, 'true');
        game_game_getUserTable();
        framework_session_setData(FIDEOS_AUTH_SESSION_TOKEN, framework_auth_createToken());
    }
}

function framework_auth_createToken()
{
    return sha1($_SERVER['HTTP_USER_AGENT'] . time() . rand(0, 1000000));
}

function framework_auth_getUserToken()
{
    if (!isset(framework_session_getAll()[FIDEOS_AUTH_SESSION_TOKEN])) {
        framework_session_setData(FIDEOS_AUTH_SESSION_TOKEN, framework_auth_createToken());
    }
    return framework_session_getAll()[FIDEOS_AUTH_SESSION_TOKEN];
}

function framework_auth_checkPostRequestWithToken()
{
    if (!isset(framework_request_getSERVERData()['HTTP_X_CSRF_TOKEN'])) {
        return false;
    }

    if (framework_request_getSERVERData()['HTTP_X_CSRF_TOKEN'] != framework_auth_getUserToken()) {
        return false;
    }

    return true;
}