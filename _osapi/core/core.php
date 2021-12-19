<?php

require_once(OA_MODULE . 'Dotenv.php');
require_once(OA_MODULE . 'Loader.php');
Dotenv::load(OA_ENV_FILE);

Loader::req(OA_CORE . '/SH1');
Loader::req('CONF🦄/' . 🌈ENV);
Loader::req('MOD🦄/DB/' . 🌈DB_ENGINE);
Loader::req('MOD🦄/Logger');
Loader::req('MOD🦄/APIException');
Loader::req('MOD🦄/Responder');
Loader::req('MOD🦄/Router');
Loader::req('MOD🦄/Halt');
Loader::req('MOD🦄/Validate');
Loader::req('MOD🦄/Request');
Loader::req(OA_CORE . '/SH2');

📝::start();
DB::connect();
🔎📨();

if (🌈DEBUG) echo '<style>html {background: black; color: white;}</style>';
else header('Content-Type: application/json; charset=UTF-8');

date_default_timezone_set(🌈TIMEZONE);
header('Access-Control-Allow-Origin: ' . 🌈HTTP_AC_ORIGIN);
header('Access-Control-Allow-Credentials: true');
header('Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With');
header('Access-Control-Max-Age: ' . 🌈HTTP_AC_MAX_AGE);