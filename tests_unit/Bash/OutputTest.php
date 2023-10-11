<?php

namespace AKlump\LoftLib\Tests\Bash;

use PHPUnit\Framework\TestCase;
use AKlump\LoftLib\Bash\Output;

/**
 * @covers \AKlump\LoftLib\Bash\Output
 */
class OutputTest extends TestCase {

  public function testList() {
    $output = Output::tree(['do', 're', 'mi']);
    $this->assertSame("├── do\n├── re\n└── mi\n", $output);
  }

}
