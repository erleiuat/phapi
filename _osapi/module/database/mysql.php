<?php

class DB {

  static $con = null;

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

    if (self::$con->connect_error) return false;
    return true;
  }

  static function exec($query) {
    if (self::$con->query($query) === true) return true;
    return false;
  }
}
