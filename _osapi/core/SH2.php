<?php

function 🌟($path) {
  Loader::req($path);
}

function 💥($code, $message = false) {
  Halt::stop($code, $message);
}

function 🔎📨($data = '🚀', $params = '📌', $input = '📥') {
  Request::get($data, $params, $input);
}

function 😼📝($content){
  Responder::addContent($content);
}

function 😺✅($message, $status = 201) {
  Responder::success($message, $status);
}

function 😿❌($message, $error, $status = 500) {
  Responder::error($message, $error, $status);
}


class_alias('Responder', '🐺');
class_alias('Validate', '🔎');
class_alias('Logger', '📝');
class_alias('Loader', '🔘');
class_alias('DB', '🎆');
