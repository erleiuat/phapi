<?php

class RouterConfig {
  static $config = [

    'GET' => [
      'TEST' => [
        'PING' => [
          'method' => 'GET',
          'route' => 'GET:TEST.PING',
          'path' => 'ROU🦄/test/ping'
        ],
        'HASH' => [
          'method' => 'GET',
          'route' => 'GET:TEST.HASH',
          'path' => 'ROU🦄/test/hash'
        ]
      ]
    ],

    'POST' => [
      'ACCOUNT' => [
        'CREATE' => [
          'method' => 'POST',
          'route' => 'POST:ACCOUNT.CREATE',
          'path' => 'ROU🦄/Account/create'
        ]
      ]
    ],

    'PUT' => [],

    'PATCH' => [],

    'DELETE' => [],

    'OPTIONS' => [],

  ];
}
