<?php

namespace AKlump\LoftLib\Tests;

class DatasetTestBase extends \PHPUnit\Framework\TestCase {

  /**
   * Provides data for testDefaults.
   *
   * Enter each key and it's default value.
   *
   * @dataProvider dataForTestDefaultsProvider
   */
  public function testDefaults($key, $value) {
    $classname = get_class($this->obj);
    $schema = $classname::getSchema();
    $this->assertSame($value, $schema[$key]['default']);
  }

  /**
   * Provides data for testInvalidFormatShowsProblems.
   *
   * Add some keys (string types) for with values that should not pass the
   * match().
   *
   * @dataProvider dataForTestInvalidFormatShowsProblemsProvider
   */
  public function testInvalidFormatShowsProblems($key = NULL, $invalidValue = NULL) {
    if ($key) {
      $this->objArgs[0][$key] = $invalidValue;
      $this->createObj();
      $this->assertArrayHasKey($key, $this->obj->validate()->getProblems());
    }
    else {
      $this->assertTrue(TRUE);
    }
  }

  /**
   * Provides data for testMissingKeyShowsProblem.
   *
   * List all the required keys that exist in $this->objArgs
   *
   * @dataProvider dataForTestMissingKeyShowsProblemProvider
   */
  public function testMissingFieldShowsProblem($key, $master_key = NULL) {
    unset($this->objArgs[0][$key]);
    $this->createObj();
    $problems = $this->obj->validate()->getProblems();
    $master_key = empty($master_key) ? $key : $master_key;
    $this->assertCount(1, $problems[$master_key]);
  }

  public function testValidate() {
    $problems = $this->obj->validate()->getProblems();
    $this->assertCount(0, $problems);
  }
}
