<?php

class Validate {

  static $tests = [];
  static $defaults = [
    'string' => [
      'min' => 1,
      'max' => 254,
      'sanitize' => true,
    ],
    'mail' => [
      'min' => 3,
      'max' => 254,
      'sanitize' => true,
      'online' => true,
      'blacklist' => ['muellmail.com']
    ],
    'url' => [
      'min' => 2,
      'max' => 254,
      'sanitize' => true,
      'protocol' => 'http://',
      'online' => true,
      'port' => 80,
    ],
    'username' => [
      'min' => 1,
      'max' => 80,
      'sanitize' => true,
      'regex' => '/^(?=.{1,80}$)(?![_.])(?!.*[_.]{2})[a-zA-Z0-9._]+(?<![_.])$/'
    ],
    'password' => [
      'min' => 8,
      'max' => 254,
      'sanitize' => false,
    ]
  ];


  static function init($key, $arr, $opt, $default = null, $stringify = false) {
    if (array_key_exists($key, self::$tests)) Halt::stop('OA_VAL001', $key);
    self::$tests[$key] = [
      'required' => $opt['required'],
      'default' => $default,
      'options' => $opt,
      'passed' => true,
      'issues' => [],
    ];
    if (!array_key_exists($key, $arr)) return null;
    return $stringify ? trim(strval($arr[$key])) : $arr[$key];
  }


  static function getOpts($type, $options, $required) {
    return array_merge(self::$defaults[$type], $options, ['required' => $required]);
  }


  static function rValue($key, $value) {
    if (self::$tests[$key]['passed']) {
      if (!self::$tests[$key]['options']['sanitize']) return $value;
      return htmlspecialchars($value);
    };
    return self::$tests[$key]['default'];
  }


  static function addIssue($key, $issue, $critical = false) {
    if ($critical) self::$tests[$key]['passed'] = false;
    array_push(self::$tests[$key]['issues'], [
      'message' => $issue,
      'critical' => $critical,
    ]);
  }


  static function rAddIssue($key, $value, $issue, $critical = false) {
    self::addIssue($key, $issue, $critical);
    return self::rValue($key, $value);
  }


  static function getIssue($key) {
    $issues = [];
    foreach (self::$tests[$key]['issues'] as $issue) array_push($issues, $issue['message']);
    return $issues;
  }


  static function getIssues($key = false) {
    if ($key) return self::getIssue($key);
    $issues = [];
    foreach (self::$tests as $el => $info) {
      $issue = self::getIssue($el);
      if (count($issue)) $issues[$el] = $issue;
    }
    return $issues;
  }


  static function passed($key = false) {
    if ($key) return self::$tests[$key]['passed'];
    foreach (self::$tests as $test) if (!$test['passed']) return false;
    return true;
  }


  static function checkLen($key, $len, $opt) {
    if ($len < $opt['min'])
      self::addIssue($key, 'Value too small (' . $len . '/' . $opt['min'] . ')', $opt['required']);
    if ($len > $opt['max'])
      self::addIssue($key, 'Value too big (' . $len . '/' . $opt['max'] . ')', $opt['required']);
  }


  static function hostOnline($host, $port = 80) {
    📝::write('Validate::hostOnline()', 'Pinging "' . $host . ':' . $port . '".', 'trace');
    $fp = fsockopen($host, $port, $hostOnlineErrCode, $hostOnlineErrMsg, 3);
    if ($fp === false) {
      📝::write('Validate::hostOnline()', 'Host "' . $host . ':' . $port . '" offline.', 'warn');
      return false;
    }
    fclose($fp);
    📝::write('Validate::hostOnline()', 'Host "' . $host . ':' . $port . '" online.', 'trace');
    return true;
  }


  static function string($key, $array, $required = false, $options = []) {
    $opt = self::getOpts('string', $options, $required);
    $val = self::init($key, $array, $opt, null, true);

    self::checkLen($key, strlen($val), $opt);

    return self::rValue($key, $val);
  }


  static function url($key, $array, $required = false, $options = []) {
    $opt = self::getOpts('url', $options, $required);
    $val = self::init($key, $array, $opt, null, true);

    $val = filter_var($val, FILTER_SANITIZE_URL);
    $parts = explode('/', str_replace(['http:', 'https:', '//'], '', $val));

    if (!filter_var($opt['protocol'] . $parts[0], FILTER_VALIDATE_URL))
      return self::rAddIssue($key, $val, 'URL Invalid', $opt['required']);

    if ($opt['online'] && !self::hostOnline($parts[0], $opt['port']))
      return self::rAddIssue($key, $val, 'URL-Host not online.', $opt['required']);

    return self::rValue($key, $val);
  }


  static function mail($key, $array, $required = false, $options = []) {
    $opt = self::getOpts('mail', $options, $required);
    $val = self::init($key, $array, $opt, null, true);

    $val = filter_var($val, FILTER_SANITIZE_EMAIL);
    self::checkLen($key, strlen($val), $opt);

    if (!filter_var($val, FILTER_VALIDATE_EMAIL))
      return self::rAddIssue($key, $val, 'Mail Invalid', $opt['required']);

    $parts = explode('@', $val);
    if (count($parts) !== 2)
      return self::rAddIssue($key, $val, 'Mail Invalid (Parts)', $opt['required']);

    $mKey = $key . '_host';
    $mail = [$mKey => $parts[1]];

    if (in_array($mail[$mKey], $opt['blacklist']))
      return self::rAddIssue($key, 'Mail Blacklisted', $opt['required']);

    if ($opt['online'] && !self::url($mKey, $mail, $required))
      return self::rAddIssue($key, 'Mail-Host offline.', $opt['required']);

    return self::rValue($key, $val);
  }


  static function username($key, $array, $required = false, $options = []) {
    $opt = self::getOpts('username', $options, $required);
    $val = self::init($key, $array, $opt, null, true);

    self::checkLen($key, strlen($val), $opt);

    if (0 >= strlen(filter_var($val, FILTER_VALIDATE_REGEXP, ['options' => ['regexp' => $opt['regex']]])))
      return self::rAddIssue($key, $val, 'Username format invalid', $opt['required']);

    return self::rValue($key, $val);
  }


  static function password($key, $array, $required = false, $options = []) {
    $opt = self::getOpts('password', $options, $required);
    $val = self::init($key, $array, $opt, null, true);

    self::checkLen($key, strlen($val), $opt);

    $chars = preg_match('@[A-Z]@', $val) + preg_match('@[a-z]@', $val);
    if (!$chars)
      self::addIssue($key, 'Password needs chars', $opt['required']);

    $number = preg_match('@[0-9]@', $val);
    if (!$number)
      self::addIssue($key, 'Password needs numbers', $opt['required']);

    # $specialChars = preg_match('@[^\w]@', $val);
    # if (!$specialChars)
    #   self::addIssue($key, 'Password needs special chars', $opt['required']);

    return self::rValue($key, $val);
  }
}
