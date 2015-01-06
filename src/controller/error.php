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