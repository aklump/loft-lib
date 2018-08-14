<?php

namespace AKlump\LoftLib\Bash;

/**
 * Handle output in the CLI.
 *
 * All methods must return a string which includes a final EOL.
 */
class Output {

  /**
   * Return an array in list form with nice bullets.
   *
   * @param array $items
   *   The array of items.
   *
   * @return string
   *   The string to output.
   */
  public static function list(array $items) {
    $build = [];
    foreach ($items as $index => $item) {
      if ($index + 1 === count($items)) {
        $build[] = "└── $item";
      }
      else {
        $build[] = "├── $item";
      }
    }

    return implode(PHP_EOL, $build) . PHP_EOL;
  }

}
