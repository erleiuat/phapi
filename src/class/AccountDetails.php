<?php

class AccountDetails {

  static $table = [
    'name' => 'account_details',
    'rows' => [
      'accountID' => [
        'name' => 'account_id',
        'type' => 'VARCHAR(50)',
        'null' => false,
        'primary' => true,
        'reference' => ['account', 'account_id']
      ],
      'gender' => [
        'name' => 'gender',
        'type' => 'VARCHAR(255)'
      ],
    ]
  ];

  private static $account = null;
  private static $gender = null;
}
