<?php

namespace AKlump\LoftLib\Code;

/**
 * A class for working with arrays.
 */
class Arrays {

  /**
   * Return a new array with a key renamed, maintain the element value.
   *
   * @param array $array
   *   The original array.
   * @param string $old_key
   *   The key to replace.
   * @param string $new_key
   *   The new key to replace with.
   *
   * @return array
   *   A new array with the key replaced.
   */
  public static function replaceKey(array $array, $old_key, $new_key) {
    $keys = array_keys($array);
    $index = array_search($old_key, $keys);

    if ($index !== FALSE) {
      $keys[$index] = $new_key;
      $array = array_combine($keys, $array);
    }

    return $array;
  }

}
