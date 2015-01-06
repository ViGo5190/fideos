<?php
/**
 * @author Stan Gumeniuk i@vigo.su
 */

function controller_page_index()
{
    $c = framework_template_compileTemplate('layout', array(
        'container' => 'Hello, world!',
    ));
    framework_response_setContent($c);
}

function controller_page_foo()
{
    framework_response_setContent('foo!!');
}