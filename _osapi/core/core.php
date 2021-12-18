<?php

require_once(OA_ROOT . 'module/loader/loader.php');
Loader::req('%MOD%/dotenv/dotenv');
Dotenv::load(OA_ENV_FILE);
Loader::req('%CONF%/' . API_ENV);

Loader::req('%MOD%/database/' . API_DB_ENGINE);
DB::connect();

date_default_timezone_set(API_TIMEZONE);
header('Access-Control-Allow-Origin: ' . API_HTTP_AC_ORIGIN);
header('Content-Type: application/json; charset=UTF-8');
header('Access-Control-Allow-Credentials: true');
header('Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With');
header('Access-Control-Max-Age: ' . API_HTTP_AC_MAX_AGE);
