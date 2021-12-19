<?php

class HaltConfig {
  static $config = [
    'ACC001' => [
      'routes' => ['ROU🦄/Account/create'],
      'message' => '',
      'status' => 422,
    ],
    'ACC002' => [
      'routes' => ['ROU🦄/Account/create'],
      'message' => 'Username exists',
      'status' => 422,
    ]
  ];
}
