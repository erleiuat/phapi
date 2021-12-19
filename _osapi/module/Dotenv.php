<?php

class Dotenv {

  static $globalsPrefix = '🌈';

  static function load($envFile) {
    $handle = fopen($envFile, "r");
    if ($handle) while (($line = fgets($handle)) !== false) {
      $line = trim($line);
      if (str_starts_with($line, '#') || !str_contains($line, '=')) continue;
      $parts = explode('=', $line);
      define(self::$globalsPrefix . trim($parts[0]), trim($parts[1]));
    }
    fclose($handle);
  }
}
