<?php
/**
 * @author Stan Gumeniuk i@vigo.su
 */

function controller_game_index()
{
    $c = framework_template_compileTemplate('game/layout', array(
        'container' => 'Hello, world!',
    ));
    framework_response_setContent($c);
}