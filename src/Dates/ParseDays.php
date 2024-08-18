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
    preg_match_all('#(\d+)\s*(st|nd|rd|th)#i', $date_description, $matches, PREG_PATTERN_ORDER);

    return $matches[1] ?? [];
  }

}
