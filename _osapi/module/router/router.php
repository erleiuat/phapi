<?php

Loader::req('%BASE%' . API_PATH_ROUTES_CONFIG);

class Router extends RouterConfig {

  static $route = [
    'method' => 'PUT, PATCH, DELETE, POST, GET, OPTIONS',
    'process' => null,
    'path' => null,
  ];

  static function getRoute($start, $parts, $point) {
    if (count($parts) > 0) {
      if (array_key_exists($parts[0], $start)) {
        $state = $start[$parts[0]];
        array_shift($parts);
        return self::getRoute($state, $parts, $point);
      }
      return false;
    }
    if ($start['route'] == $point) return $start;
    return false;
  }

  static function resolve() {
    $method = strtoupper($_SERVER['REQUEST_METHOD']);
    $url = trim(strtoupper(parse_url($_SERVER['REQUEST_URI'])['path']));
    $parts = explode("/", $url);
    array_shift($parts);
    $point = $method . ':' . implode('.', $parts);

    Logger::write('Router::resolve()', 'Request POINT: ' . $point);

    if (array_key_exists($method, self::$routes)) {
      $r = self::getRoute(self::$routes[$method], $parts, $point);
      if ($r)
        self::$route = array_merge(self::$route, $r);
      else
        Logger::write('Router::resolve()', 'NOT FOUND: ' . $point, 'warn');
    }
  }
}
