<?php

namespace AKlump\LoftLib\Tests\Code;

use AKlump\LoftLib\Code\Dataset;

class DatasetBravo extends Dataset {

  /**
   * {@inheritdoc}
   */
  protected static function pathToJsonSchema() {
    return __DIR__ . '/DatasetBravo.schema.json';
  }

  protected static function ignoreKey($key) {
    return is_numeric($key);
  }
}

class SomeCustomClass {

  // @see DatasetBravo.schema.json
}
