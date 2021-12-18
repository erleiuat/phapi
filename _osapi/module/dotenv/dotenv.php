<?php

class Dotenv {

  static $defaults = [
    'API_ENV' => 'local',
    'API_DB_SERVER' => 'localhost',
    'API_DB_PORT' => '3306',
    'API_DB_DATABASE' => 'osapi',
    'API_DB_USER' => 'root',
    'API_DB_PASSWORD' => 'root',
    'API_DB_TABLE_PREFIX' => 'oa',
  ];

  static function load($envFile) {
    $opts = [];
    $handle = fopen($envFile, "r");
    if ($handle) while (($line = fgets($handle)) !== false) {
      $line = trim($line);
      if (str_starts_with($line, '#') || !str_contains($line, '=')) continue;
      $parts = explode('=', $line);
      define('API_' . $parts[0], $parts[1]);
    }
    fclose($handle);
  }
}
