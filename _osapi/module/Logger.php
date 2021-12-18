<?php

class Logger {

  static $table = 'osapi_sys_log';
  static $trace = null;

  static function write($process, $info, $level = 'trace', $db = API_LOG_DB) {
    if (API_LOG_FILE) {
      $line =
        '[' . $level . '][' . date("H:i:s") . '][' . $process . '] ' . $info .
        ' [' . json_encode(self::$trace) . ']' . PHP_EOL;
      $fName = OA_BASE_PATH . API_PATH_LOG_FILES . '/' . date("Y_m_d") . '.log';
      if (!file_exists($fName)) mkdir(dirname($fName), 0777, true);
      file_put_contents($fName, $line, FILE_APPEND);
    }

    if ($db && DB::ready())
      DB::insert(
        self::$table,
        ['level', 'process', 'info', 'trace'],
        [[$level, $process, $info, json_encode(self::$trace)]]
      );
  }

  static function start() {

    if (!empty($_SERVER['HTTP_CLIENT_IP']))
      $ip = $_SERVER['HTTP_CLIENT_IP'];
    elseif (!empty($_SERVER['HTTP_X_FORWARDED_FOR']))
      $ip = $_SERVER['HTTP_X_FORWARDED_FOR'];
    else
      $ip = $_SERVER['REMOTE_ADDR'];

    self::$trace = [
      'ip' => $ip,
      'url' => $_SERVER['REQUEST_URI'],
      'user_agent' => $_SERVER['HTTP_USER_AGENT'],
      'remote_address' => $_SERVER['REMOTE_ADDR'],
      'remote_port' => $_SERVER['REMOTE_PORT'],
      'php_self' => $_SERVER['PHP_SELF'],
    ];

    if (isset($_SERVER['HTTP_X_FORWARDED_FOR']))
      self::$trace['x_forwarded_for'] = $_SERVER['HTTP_X_FORWARDED_FOR'];

    if (isset($_SERVER['HTTP_REFERER']))
      self::$trace['referer'] = $_SERVER['HTTP_REFERER'];
  }
}
