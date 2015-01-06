<?php
/**
 * @author Stan Gumeniuk i@vigo.su
 */

function controller_index_index()
{
    $c = framework_template_compileTemplate('layout', array(
        'container' => 'index!!',
    ));
    framework_response_setContent($c);
}

function controller_index_foo()
{
    framework_response_setContent('foo!!');
}