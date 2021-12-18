<?php

require_once(OA_MODULE . 'Dotenv.php');
require_once(OA_MODULE . 'Loader.php');
Dotenv::load(OA_ENV_FILE);

Loader::req('%CONF%/' . API_ENV);

Loader::req('%MOD%/DB/' . API_DB_ENGINE);
Loader::req('%MOD%/Logger');
Logger::start();
DB::connect();

Loader::req('%MOD%/Responder');
Loader::req('%MOD%/Router');

if (API_DEBUG) echo '<style>html {background: black; color: white;}</style>';
else header('Content-Type: application/json; charset=UTF-8');

date_default_timezone_set(API_TIMEZONE);
header('Access-Control-Allow-Origin: ' . API_HTTP_AC_ORIGIN);
header('Access-Control-Allow-Credentials: true');
header('Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With');
header('Access-Control-Max-Age: ' . API_HTTP_AC_MAX_AGE);
