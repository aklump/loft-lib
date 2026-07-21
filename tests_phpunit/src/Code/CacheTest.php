<?php

namespace AKlump\LoftLib\Tests\Code;


use AKlump\LoftLib\Code\Cache;
use PHPUnit\Framework\TestCase;

/**
 * @covers \AKlump\LoftLib\Code\Cache
 */
final class CacheTest extends TestCase {

  protected $obj;

  protected $objArgs;

  /**
   * Provides data for testIdMethodSortsAndReturnsSameCacheId.
   */
  public static function dataForTestIdMethodSortsAndReturnsSameCacheIdProvider() {
    $tests = array();
    $tests[] = array(
      ['do' => 're', 'mi' => ['zulu' => 'z', 'alpha' => 'a', 'mike' => 'm']],
      ['mi' => ['zulu' => 'z', 'mike' => 'm', 'alpha' => 'a'], 'do' => 're',],
    );
    $tests[] = array(
      ['do' => 're', 'mi' => 'fa'],
      ['mi' => 'fa', 'do' => 're'],
    );

    return $tests;
  }

  /**
   * @dataProvider dataForTestIdMethodSortsAndReturnsSameCacheIdProvider
   */
  public function testIdMethodSortsAndReturnsSameCacheId($a, $b) {
    $this->assertSame(Cache::id($a), Cache::id($b));
  }

  public function setUp(): void {
    $this->objArgs = [];
    $this->createObj();
  }

  protected function createObj() {
    $this->obj = new Cache();
  }
}
