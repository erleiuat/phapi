<?php

class Loader {

  static $search = [
    'OA🦄',     // OA_ROOT, 
    'MOD🦄',    // OA_MODULE, 
    'CONF🦄',   // OA_CONF, 
    'BASE🦄',   // OA_BASE_PATH, 
    'ROU🦄',    // OA_BASE_PATH . 🌈PATH_ROUTES, 
    'SRC🦄',    // OA_BASE_PATH . 🌈PATH_SRC,
    'CLS🦄',    // OA_BASE_PATH . 🌈PATH_CLASSES,
  ];

  static $replace = [
    OA_ROOT,
    OA_MODULE,
    OA_CONF,
    OA_BASE_PATH,
    OA_BASE_PATH . 🌈PATH_ROUTES,
    OA_BASE_PATH . 🌈PATH_SRC,
    OA_BASE_PATH . 🌈PATH_CLASSES,
  ];

  static function getPath($file, $ext) {
    if (!str_contains($file, $ext)) $file .= '.' . str_replace('.', '', $ext);
    return str_replace(self::$search, self::$replace, $file);
  }

  static function inc($file, $extention = 'php') {
    $path = self::getPath($file, $extention);
    include_once $path;
    return $path;
  }

  static function req($file, $extention = 'php') {
    $path = self::getPath($file, $extention);
    require_once $path;
    return $path;
  }
}
