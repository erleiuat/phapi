<?php // Better don't change stuff in here m8

require_once(OA_ROOT . 'core/core.php');

Logger::write('Osapi', 'Request received');
Router::resolve();

header("Access-Control-Allow-Methods: " . Router::$route['method']);

if (!Router::$route['path'])
    Responder::error('Not Found', 'OA0001', 404);
else
    Loader::req(Router::$route['path']);

Responder::send();

/*

try {

    Log::init();
    Database::connect();
    Router::getRoute();

    header("Access-Control-Allow-Methods: " . Router::$route->method);

    if (!Router::$route->script) Response::success(200, "Route has no script");
    else {
        Log::setProcess(Router::$route->process);
        require Router::$route->script;
    }

} catch (\Exception $e) {

    Log::addInformation("ERR_MSG=" . $e->getMessage());
    
    if(get_class($e) === "ApiException") {
        Log::addInformation("ERR_CODE=" . $e->getErrorCode());
        Log::addInformation("ERR_RESP=" . $e->getResponseCode());
        Log::addInformation("ERR_APIMSG=" . $e->getErrorMessage());
        if (Log::$level === "trace") {
            if ($e->getCode() === 500) Log::setLevel('error');
            else Log::setLevel('debug');
        }
        Response::error($e->getResponseCode(), $e->getErrorCode(), $e->getErrorMessage());
    } else {
        Log::addInformation("ERR_CODE=G0001(" . $e->getCode() . ")");
        if (Log::$level === "trace") Log::setLevel('fatal');
        Response::error(500, 'G0001', $e->getMessage() . ' (' . $e->getCode() . ')');
    }

}

Response::send();

Log::write(ENV_Main::log_levels);
*/