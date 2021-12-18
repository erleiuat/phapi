<?php

class DB {

  static $con = null;

  static function ready() {
    if (self::$con) return true;
    return false;
  }

  static function getCon() {
    return self::$con;
  }

  static function setCon($con) {
    self::$con = $con;
  }

  static function connect() {
    self::setCon(new mysqli(
      API_DB_SERVER,    // host
      API_DB_USER,      // username
      API_DB_PASSWORD,  // password
      API_DB_DATABASE,  // dbname
      API_DB_PORT,      // port
    ));

    if (self::$con->connect_error) {
      Logger::write('DB::connect()', self::$con->connect_error, 'error');
      return false;
    };

    return true;
  }

  static function exec($query) {
    if (API_LOG_QUERY) Logger::write('DB->exec()', 'Running Query: "' . $query . '"', 'trace', false);
    if (self::$con->query($query) === true) return true;
    Logger::write('DB->exec()', 'Query failed: "' . self::getCon()->error . '"', 'error', false);
    return false;
  }

  static function insert($table, $keys, $values) {

    $sql_insert = 'INSERT INTO ' . API_DB_TABLE_PREFIX . $table;
    $sql_keys = '(' . implode(', ', $keys) . ')';
    $sql_vals = [];

    if (is_array($values[0]))
      foreach ($values as $e)
        array_push($sql_vals, "('" . implode("','", $e) . "')");
    else
      $sql_vals = $values;

    $sql =
      $sql_insert . ' ' .
      $sql_keys . ' VALUES ' .
      implode(',', $sql_vals) .
      ';';

    return self::exec($sql);
  }
}
