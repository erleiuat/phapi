<?php

class Request {

  static function input() {
    $data = json_decode(file_get_contents('php://input'));
    if (!$data) return [];
    if (json_last_error() !== 0) Halt::stop('OA_RQ001');
    return $data;
  }

  static function processed($arr) {
    $data = [];
    foreach ($arr as $k => $v) $data[htmlspecialchars($k)] = htmlspecialchars($v);
    return $data;
  }

  static function formData() {
    return self::processed($_POST);
  }

  static function queryParams() {
    return self::processed($_GET);
  }

  static function get($data = false, $params = false, $input = false) {
    $req = [
      'data' => self::formData(),
      'params' => self::queryParams(),
      'input' => self::input(),
    ];
    if ($data) define($data, $req['data']);
    if ($params) define($params, $req['params']);
    if ($input) define($input, $req['input']);
    return $req;
  }
}
