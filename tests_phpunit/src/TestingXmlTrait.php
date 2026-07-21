<?php

namespace AKlump\LoftLib\Tests;


trait TestingXmlTrait {

  public function assertXMLEquals($control, $xml) {
    if (is_array($control)) {
      $subject = (array) $xml;
    }
    else {
      $subject = (string) $xml;
    }

    return $this->assertEquals($control, $subject);
  }

  public function assertXMLHasChild($child, $xml) {
    $this->assertArrayHasKey($child, (array) $xml->children());
  }

}
