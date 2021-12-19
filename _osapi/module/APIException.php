<?php

class APIException extends Exception {

  protected $status;
  protected $error;
  protected $msg;

  public function __construct($status = 500, $error = 'G0001', $message = "", Exception $previous = null) {
    $this->status = $status;
    $this->error = $error;
    $this->msg = $message;
    parent::__construct("", intval($status), $previous);
  }

  final public function status() {
    return $this->status;
  }

  final public function code() {
    return $this->error;
  }

  final public function message() {
    return $this->msg;
  }
}
