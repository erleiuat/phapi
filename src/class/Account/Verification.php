<?php

class Verification {

  private $db = 'account_verification';
  private $account = null;

  private $mail = false;
  private $mailCode = false;
  private $mailVerified = false;

  private $phone = false;
  private $phoneCode = false;
  private $phoneVerified = false;

  private $identity = false;
  private $identityProof = false;
  private $identityVerified = false;

  public function __construct($account) {
    $this->account = $account;
  }

  public function getID() {
    return $this->account->getID();
  }

  public function create() {
    DB::insert($this->db, [
      'account_id',
      'mail_code'
    ], [
      $this->getID(),
      $this->mailCode
    ]);
  }

  public static function randomString($length = 10) {
    $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
    $charactersLength = strlen($characters);
    $randomString = '';
    for ($i = 0; $i < $length; $i++) {
      $randomString .= $characters[rand(0, $charactersLength - 1)];
    }
    return $randomString;
  }

  public function getMailCode() {
    $mailCode = $this->randomString(6);
    $this->mailCode = password_hash($mailCode, PASSWORD_BCRYPT);
    return $mailCode;
  }
}
