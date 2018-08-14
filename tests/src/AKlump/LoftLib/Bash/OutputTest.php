<?php

namespace AKlump\LoftLib\Bash;

class OutputTest extends \PHPUnit_Framework_TestCase {

  public function testList() {
    $output = Output::list(['do', 're', 'mi']);
    $this->assertSame("├── do\n├── re\n└── mi\n", $output);
  }

}
