<?php
/**
 * @author Stan Gumeniuk i@vigo.su
 */


function framework_request_getPOSTData()
{
    return $_POST;
}

function framework_request_getGETData()
{
    return $_GET;
}

function framework_request_getSERVERData()
{
    return $_SERVER;
}