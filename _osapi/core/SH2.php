<?php

function π($path) {
  Loader::req($path);
}

function π₯($code, $message = false) {
  Halt::stop($code, $message);
}

function ππ¨($data = 'π', $params = 'π', $input = 'π₯') {
  Request::get($data, $params, $input);
}

function πΌπ($content){
  Responder::addContent($content);
}

function πΊβ($message, $status = 201) {
  Responder::success($message, $status);
}

function πΏβ($message, $error, $status = 500) {
  Responder::error($message, $error, $status);
}


class_alias('Responder', 'πΊ');
class_alias('Validate', 'π');
class_alias('Logger', 'π');
class_alias('Loader', 'π');
class_alias('DB', 'π');
