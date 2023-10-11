<?php

namespace AKlump\LoftLib\Code;


use AKlump\LoftLib\Testing\PhpUnitTestCase;

/**
 * @covers \AKlump\LoftLib\Code\InfiniteSubset
 */
class InfiniteSubsetTest extends PhpUnitTestCase {

  public function testPassingFourthArgumentThrows() {
    $this->expectException(\InvalidArgumentException::class);
    $state = [];
    $data = new \stdClass();
    new InfiniteSubset('foo.bar', [1, 2, 4, 8], $state, $data);
  }

  public function testKeysArePreserved() {
    $this->objArgs[2] = [];
    $this->objArgs[1] = [
      'a' => 'apply',
      'b' => 'banana',
      'c' => 'cherry',
      'd' => 'dragonfruit',
    ];
    $this->createObj();
    $slice = $this->obj->slice(4);
    $this->assertArrayHasKey('a', $slice);
    $this->assertArrayHasKey('b', $slice);
    $this->assertArrayHasKey('c', $slice);
    $this->assertArrayHasKey('d', $slice);
  }

  public function testEmptyDataSetToSliceThrows() {
    $this->expectException(\InvalidArgumentException::class);
    $this->objArgs[1] = [];
    $this->objArgs[2] = [];
    $this->createObj();
    $this->assertSame(array(), $this->obj->slice(1));
  }

  public function testWorksWhenPathIsEmptyString() {
    $this->objArgs[0] = '';
    $this->createObj();
    $slice = $this->obj->slice(2);
    $this->assertCount(2, $slice);

    $this->assertNotEmpty($this->objArgs[2]['dataset']);
  }

  public function testIfCountIsReallyBigThingsDontBreak() {
    $slice = $this->obj->slice(999);
    $this->assertCount(999, $slice);
    $this->assertCount(7, array_unique($slice));
  }

  public function testIfCountIsGreaterThanDatasetCountValuesWillRepeat() {
    $slice = $this->obj->slice(9);
    $this->assertCount(9, $slice);
    $this->assertCount(7, array_unique($slice));

    $this->assertCount(5, $this->callAsPublic('getStack'));
  }

  public function testSliceReturnsCorrectNameAndReducesStackBySame() {
    $this->assertCount(2, $this->obj->slice(2));
    $this->assertCount(5, $this->callAsPublic('getStack'));
  }

  public function testGetStackProducesArrayThatDoesntMatchDatasetButCountDoesMatch() {
    $this->assertNotSame($this->objArgs[1], $this->callAsPublic('getStack'));
    $this->assertCount(count($this->obj->getDataset()), $this->callAsPublic('getStack'));
  }

  public function testGetDatasetProducesArrayThatMatchesArgument() {
    $this->assertSame($this->objArgs[1], $this->obj->getDataset());
  }

  public function testContainerWasFilledWithDataByReference() {
    $this->assertNotEmpty($this->objArgs[2]['do']['alpha'][123]);
  }

  public function testWorksWhenPathIsArray() {
    $path = ['foo'];
    $dataset = [1, 2, 3, 4];
    $obj = new InfiniteSubset($path, $dataset);
    $foo = $obj->slice(1);
    $this->assertContains(array_values($obj->slice(1))[0], [1, 2, 3, 4]);
    $this->assertContains(array_values($obj->slice(1))[0], [1, 2, 3, 4]);
    $this->assertContains(array_values($obj->slice(1))[0], [1, 2, 3, 4]);
    $this->assertContains(array_values($obj->slice(1))[0], [1, 2, 3, 4]);
    $this->assertContains(array_values($obj->slice(1))[0], [1, 2, 3, 4]);
    $this->assertContains(array_values($obj->slice(1))[0], [1, 2, 3, 4]);
    $this->assertContains(array_values($obj->slice(1))[0], [1, 2, 3, 4]);
  }

  public function setUp(): void {
    $this->objArgs = [
      'do.alpha.123',
      [
        // Do not change this area or it will break tests.
        'do',
        're',
        'mi',
        'fa',
        'so',
        'la',
        'ti',
      ],
      [],
    ];
    $this->createObj();
  }

  protected function createObj() {
    list($path, $dataset) = $this->objArgs;
    $this->obj = new InfiniteSubset($path, $dataset, $this->objArgs[2]);
  }

}
