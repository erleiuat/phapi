<?php 

/* 

  Load your .env as well as Osapi.

*/

define('ENV', './env.php');
require_once ENV;
require_once ENV::OSAPI_ROOT . ENV::OSAPI_MAIN;
