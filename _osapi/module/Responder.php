<?php

class Responder {

  # https://developer.mozilla.org/de/docs/Web/HTTP/Status
  static $status = 200;
  static $error = null;
  static $content = [];
  static $message = null;
  static $success = false;

  static function addContent($content) {
    array_push(self::$content, $content);
  }

  static function success($message, $status = 201) {
    self::$success = true;
    self::$status = $status;
    self::$message = $message;
    📝::write('Responder::success()', 'Successful (' . $status . ')');
  }

  static function error($message, $error, $status = 500) {
    self::$success = false;
    self::$status = $status;
    self::$message = $message;
    self::$error = $error;
    📝::write('Responder::error()', 'Error (' . $status . ', ' . $error . ') -> ' . 🐯($message), 'warn');
  }

  static function send() {

    if (self::$success) {
      $reply = 🐯([
        "success" => true,
        "message" => self::$message,
        "content" => self::$content
      ]);
      📝::write('Responder::send()', 'Sending Response: ' . $reply);
    } else {
      $reply = 🐯([
        "success" => false,
        "message" => self::$message,
        "error" => self::$error
      ]);
      📝::write('Responder::send()', 'Sending Response: ' . $reply, 'warn');
    }

    http_response_code(self::$status);
    echo $reply;
  }
}
