<?php

namespace AKlump\LoftLib\Dates;

class ParseDays {

  /**
   * Parse a date description for all day numbers.
   *
   * @param string $date_description
   *
   * @return int[]
   */
  public function __invoke(string $date_description): array {
    $numbers = [];
    $pattern = '#(\d+)(?:st|nd|rd|th)?\s*-\s*(\d+)(?:st|nd|rd|th)?#i';
    if (preg_match_all($pattern, $date_description, $matches, PREG_SET_ORDER)) {
      foreach ($matches as $match) {
        $numbers = array_merge($numbers, range($match[1], $match[2]));
      }
    }

    preg_match_all('#(\d+)\s*(st|nd|rd|th)#i', $date_description, $matches, PREG_PATTERN_ORDER);
    $numbers = array_merge($numbers, $matches[1] ?? []);

    return array_values(array_unique(array_map('intval', $numbers)));
  }

}
