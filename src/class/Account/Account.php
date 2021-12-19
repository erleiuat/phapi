<?php

class Account {

  private $db = 'account';
  private $accountID = null;
  private $password = null;

  public $mail = null;
  public $username = null;

  public function __construct($username = false) {
    if ($username) $this->username = $username;
  }

  private function setID($id) {
    $this->accountID = $id;
    return $this;
  }

  public function getID() {
    return $this->accountID;
  }

  public function generateID() {
    $unique = uniqid('', true);
    $time = date('Y_m_d_H_i_s', time());
    $this->setID(hash('ripemd160', $time . ':' . $unique));
    return $this;
  }

  public function setPassword($password) {
    $this->password = password_hash($password, PASSWORD_BCRYPT, ['cost' => 🌈ENCRYPTION_COST]);
    return $this;
  }

  public function read() {
    $data = DB::read($this->db, ['account_id', 'mail'], [
      'username' => $this->username
    ]);

    if (!$data) return false;
    $this->setID($data[0]['account_id']);
    $this->mail = $data[0]['mail'];
    return $this;
  }

  public function create() {
    DB::insert(
      $this->db,
      ['account_id', 'password', 'mail', 'username'],
      [$this->getID(), $this->password, $this->mail, $this->username]
    );
    return $this;
  }
}
