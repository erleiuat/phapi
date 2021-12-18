<?php

class Loader {

  static function getPath($file, $ext) {
    $sr = array('%OA%', '%MOD%', '%CONF%');
    $rp = array(OA_ROOT, OA_MODULE, OA_CONF);
    if (!str_contains($file, $ext)) $file .= '.' . str_replace('.', '', $ext);
    return str_replace($sr, $rp, $file);
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
