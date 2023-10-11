<?php

namespace AKlump\LoftLib\Tests;


trait TestingProtectedTrait {

  /**
   * Call a non-public method on $this->obj
   *
   * @param string $method The non-public method on $this->obj to call
   * @param... Additional args will be sent to the method.
   *
   * @return mixed
   */
  protected function callAsPublic($method) {
    $args = func_get_args();
    $method = array_shift($args);
    $reflector = new \ReflectionClass(get_class($this->obj));
    $method = $reflector->getMethod($method);
    $method->setAccessible('public');

    return $method->invokeArgs($this->obj, $args);
  }
}
