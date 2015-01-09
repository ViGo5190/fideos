<?php
/**
 * @author Stan Gumeniuk i@vigo.su
 */

function controller_error_404()
{
    header('HTTP/1.0 404 Not Found');

    $c = framework_template_compileTemplate('layout', array(
        'container' => '404: Not found!'
    ));
    echo $c;
}

function controller_error_401()
{
    header('HTTP/1.0 401 ');

    $c = framework_template_compileTemplate('layout', array(
        'container' => '401'
    ));
    echo $c;
}

function controller_error_500()
{
    header('HTTP/1.0 500 ');

    $c = framework_template_compileTemplate('layout', array(
        'container' => '500'
    ));
    echo $c;
}