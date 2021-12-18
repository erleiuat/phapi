<?php

class Account {

  static $table = [
    'name' => 'account',
    'rows' => [
      'accountID' => [
        'name' => 'account_id',
        'type' => 'VARCHAR(50)',
        'null' => false,
        'primary' => true
      ],
      'mail' => [
        'name' => 'mail',
        'type' => 'VARCHAR(90)',
        'null' => false
      ],
      'username' => [
        'name' => 'username',
        'type' => 'VARCHAR(40)',
        'null' => false,
        'unique' => true
      ],
      'password' => [
        'name' =>
        'password',
        'type' =>
        'VARCHAR(255)',
        'null' => false
      ],
    ]
  ];

  private static $accountID = null;
  private static $mail = null;
  private static $username = null;
  private static $password = null;
}
