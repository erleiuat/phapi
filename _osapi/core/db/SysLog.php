<?php

class SysLog {
  static $table = [
    'name' => 'osapi_sys_log',
    'rows' => [
      'sysLogID' => [
        'name' => 'sys_log_id',
        'type' => 'INT(6)',
        'auto' => true,
        'null' => false,
        'primary' => true,
        'unsigned' => true
      ],
      'level' => [
        'name' => 'level',
        'type' => 'ENUM("trace","debug","info", "warn", "error", "fatal")',
        'null' => false,
        'default' => '"trace"'
      ],
      'process' => [
        'name' => 'process',
        'type' => 'VARCHAR(50)',
      ],
      'info' => [
        'name' => 'info',
        'type' => 'TEXT',
      ],
      'stamp' => [
        'name' => 'stamp',
        'type' => 'TIMESTAMP',
        'default' => 'CURRENT_TIMESTAMP'
      ],
      'trace' => [
        'name' => 'trace',
        'type' => 'JSON',
      ],
    ]
  ];
}
