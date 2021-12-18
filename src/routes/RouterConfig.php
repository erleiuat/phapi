<?php

class RouterConfig {
  static $routes = [
    'GET' => [
      'TEST' => [
        'PING' => [
          'method' => 'GET',
          'route' => 'GET:TEST.PING',
          'path' => '%R%/test/ping'
        ]
      ]
    ],
    'POST' => [],
    'PUT' => [],
    'PATCH' => [],
    'DELETE' => [],
    'OPTIONS' => [],
  ];
}
