<?php

namespace AKlump\LoftLib\Code;

class DatasetBravo extends Dataset {

  protected static function acceptKeys() {
    return array(
      'integer',
      'double:float',
      'string',
      'array',
      'object',
      'null',
      'custom_class',
    );
  }

  protected static function requireKeys() {
    return array('integer');
  }

  protected static function ignoreKey($key) {
    return is_numeric($key);
  }

  protected static function types() {
    return array(
      'integer' => 'integer',
      'double' => 'double',
      'string' => 'string',
      'array' => 'array',
      'object' => 'object',
      'null' => 'null',
      'custom_class' => '\AKlump\LoftLib\Code\SomeCustomClass',
    );
  }

  protected static function defaults() {
    return array();
  }

  protected static function match() {
    return array();
  }

  protected static function describe() {
    return array('integer' => '');
  }

  protected static function examples() {
    return array(
      array('integer' => 34, 'double' => 98.6),
    );
  }
}

class SomeCustomClass {

}
