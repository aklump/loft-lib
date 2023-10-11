<?php

namespace AKlump\LoftLib\Tests;

class __CLassNameTest extends DatasetTestBase {


  /**
   * Provides data for testDefaults.
   *
   * Enter a test for each key and alias that has a default value.  If no
   * default values, test the first key for null.
   */
  public static function dataForTestDefaultsProvider() {
    $tests = array();
    $tests[] = array('reserves', FALSE);

    return $tests;
  }

  /**
   * Provides data for testInvalidFormatShowsProblems.
   *
   * Add some keys with invalid values.
   */
  public static function dataForTestInvalidFormatShowsProblemsProvider() {
    $tests = array();
    $tests[] = array('id', 'my.bad.id');

    return $tests;
  }

  /**
   * Provides data for testMissingKeyShowsProblem.
   *
   * List all the keys that exist in $this->objArgs, which are required, (not
   * the master, the actual key used in the
   * $this->objArgs).
   */
  public static function dataForTestMissingKeyShowsProblemProvider() {
    $tests = array();
    $tests[] = array('value');

    return $tests;
  }

  public function setUp(): void {
    $this->objArgs = [
      \__NAmespace\__CLassName::example()->get(),
    ];
    $this->createObj();
  }

  protected function createObj() {
    list ($def) = $this->objArgs;
    $this->obj = new \__NAmespace\__CLassName($def);
  }
}
