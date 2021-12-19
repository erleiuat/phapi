<?php

Loader::req('BASE🦄' . 🌈PATH_HALT_CONFIG);

class Halt extends HaltConfig {

  static $osapi = [
    'OA_DB001' => [
      'info' => '',
      'routes' => ['MOD🦄/DB'],
      'message' => 'DB::connection() failed',
      'status' => 500,
    ],
    'OA_DB002' => [
      'info' => '',
      'routes' => ['MOD🦄/DB'],
      'message' => 'DB::connection() failed',
      'status' => 500,
    ],
    'OA_RQ001' => [
      'info' => '',
      'routes' => ['MOD🦄/Request'],
      'message' => 'RequestJSON Error',
      'status' => 400,
    ],
    'OA_VAL001' => [
      'info' => '',
      'routes' => ['MOD🦄/Validate'],
      'message' => 'Duplicate key error',
      'status' => 500,
    ],
  ];

  static function get($code) {
    return array_merge(self::$config, self::$osapi)[$code];
  }

  static function stop($code, $message = false) {
    $error = self::get($code);
    if (!$message) $message = $error['message'];
    throw new APIException(
      $error['status'],
      $code,
      $message
    );
  }
}
