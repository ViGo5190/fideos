<?php
/**
 * @author Stan Gumeniuk i@vigo.su
 */

function framework_router_parseUriViaNginxReconfig()
{
    $request = framework_request_getGETData();
    if (empty($request['q'])) {
        return array();
    }

    $uri = $request['q'];
    $regex = '~^/(?P<controller>.*?)/(?P<action>.*?)/?$~';

    if (preg_match($regex, $uri, $matches)) {
        return array(
            'controller' => $matches['controller'],
            'action'     => $matches['action'],
        );
    }
}

function framework_router_parseControllerAndAction(Array $uri)
{
    if (empty($uri['controller'])) {
        $uri['controller'] = 'index';
    }

    if (empty($uri['action'])) {
        $uri['action'] = 'index';
    }

    $uri['action'] = str_replace('/', '_', $uri['action']);

    return $uri;
}

function framework_router_createFunctuinNameByUri(Array $uri)
{
    $uri = framework_router_parseControllerAndAction($uri);
    return 'controller_' . $uri['controller'] . '_' . $uri['action'];
}

function framework_router_checkExistControllerAction(Array $uri)
{
    $uri = framework_router_parseControllerAndAction($uri);

    if ($uri) {
        return function_exists(framework_router_createFunctuinNameByUri($uri));
    }

    return false;
}

function framework_router_runControllerActionByUri(Array $uri)
{
    framework_profiler_startProfileEvent('framework_router_runControllerActionByUri');
    $uri = framework_router_parseControllerAndAction($uri);
    if (!framework_router_checkExistControllerAction($uri)) {
        $uri = framework_router_parseControllerAndAction(
            array(
                'controller' => 'error',
                'action'     => '404'
            )
        );
        if (!framework_router_checkExistControllerAction($uri)) {
            die('500');
        }
    }
    framework_profiler_stopProfileEvent('framework_router_runControllerActionByUri');
    call_user_func(framework_router_createFunctuinNameByUri($uri));
}

function framework_router_run()
{

    framework_profiler_startProfileEvent('framework_router_run');
    framework_router_runControllerActionByUri(
        framework_router_parseControllerAndAction(
            framework_router_parseUriViaNginxReconfig()
        )
    );
    framework_profiler_stopProfileEvent('framework_router_run');
}
