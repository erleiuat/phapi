<?php

require_once(OA_ROOT . 'core/core.php');

try {
    📝::write('Osapi', 'Request received');
    Router::resolve();
    header("Access-Control-Allow-Methods: " . Router::$route['method']);
    define('ROUTE', Router::$route['route']);
    Loader::req(Router::$route['path']);
} catch (\Exception $e) {

    if (get_class($e) === 'APIException') Responder::error($e->message(), $e->code(), $e->status());
    else {
        Responder::error('Server Error', 'OA0001', 500);
        📝::write('Osapi', 'ERROR ' . 🐯([
            'error' => 'Server Error 500',
            'code' => $e->getCode(),
            'message' => $e->getMessage(),
            'full' => $e,
        ]), 'fatal');
    }
}

Responder::send();
