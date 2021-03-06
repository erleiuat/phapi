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

  static function getError() {
    return '[(' . self::$con->errno . ') ' . self::$con->error . ']';
  }

  static function connect($log = true) {
    try {
      self::$con = new PDO(
        'mysql:' .
          'dbname=' . ðDB_DATABASE . ';' .
          'host=' . ðDB_SERVER . ';' .
          'port=' . ðDB_PORT,
        ðDB_USER,
        ðDB_PASSWORD
      );

      self::$con->exec("SET NAMES utf8");
      self::$con->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    } catch (PDOException $e) {
      if ($log) ð::write('OA_DB001', self::getError(), 'fatal');
      Halt::stop('OA_DB001');
    }

    return true;
  }

  static function exec($query, $log = true) {
    if (ðLOG_QUERY && $log) ð::write('DB->exec()', 'Running Query: "' . $query . '"', 'trace', false);
    if (self::$con->query($query) === true) return true;
    if ($log) ð::write('DB->exec()', 'Query failed: "' . self::getError() . '"', 'error', false);
    return false;
  }

  static function insert($table, $keys, $values) {
    if (!is_array($values[0])) $values = array_merge([], [$values]);

    $vals = [];
    foreach ($values as $i => $row) {
      $entry = [];
      foreach ($keys as $e => $key) $entry[':' . $key] = $row[$e];
      array_push($vals, $entry);
    }

    $stmt = self::$con->prepare(
      'INSERT INTO ' . ðDB_TABLE_PREFIX . $table .
        '(' . implode(',', $keys) . ') ' .
        'VALUES (:' . implode(', :', $keys) . ')'
    );

    if (!$stmt) {
      ð::write('OA_DB002', self::getError(), 'fatal');
      Halt::stop('OA_DB002');
    }

    foreach ($vals as $entry) $stmt->execute($entry);
    return true;
  }

  static function read($table, $columns = ['*'], $filter = []) {

    $keys = [];
    $vals = [];
    foreach ($filter as $key => $val) {
      array_push($keys, $key . '=:' . $key);
      $vals[':' . $key] = $val;
    }

    $stmt = self::$con->prepare(
      'SELECT ' . implode(',', $columns) . ' ' .
        'FROM ' . ðDB_TABLE_PREFIX . $table .
        (count($vals) > 0 ? ' WHERE ' . implode(', ', $keys) : '')
    );
    $stmt->execute($vals);
    $result = $stmt->fetchAll();
    return count($result) ? $result : null;
  }
}

/*
return self::$db->connection->lastInsertId();
*/
