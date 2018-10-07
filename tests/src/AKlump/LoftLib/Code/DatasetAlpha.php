<?php

namespace AKlump\LoftLib\Code;

class DatasetAlpha extends Dataset {


  protected static function getPathToJsonSchema() {
    return __DIR__ . '/DatasetAlpha.schema.json';
  }

  protected static function acceptKeys() {
    return ['do', 're', 'mi:me:moi', 'pi', 'fo', 'list', 'date', 'boolean'];
  }

  protected static function defaults() {
    return [
      'do' => 'deer',
      're' => 'sun',
      'mi' => 'myself',
      'pi' => 3.14,
      'list' => [],
      'date' => Dates::z()->format(DATE_ISO8601),
    ];
  }

  protected static function match() {
    return [
      'mi' => '/^m.+/',
      'date' => Dataset::REGEX_DATEISO8601,
    ];
  }

  protected static function types() {
    return [
      'pi' => 'double|int',
      'list' => 'array',
      'boolean' => 'boolean',
    ];
  }

  protected static function examples($version = 0) {
    return [
      [
        'do' => 'The first',
        're' => 'The second',
        'me' => 'mom',
        'pi' => 3.14,
        'list' => ['blue', 'yellow'],
      ],
    ];
  }

  protected static function describe() {
    return [
      'do' => 'This is the first key',
      'list' => 'This tests how arrays fare . ',
    ];
  }

}
