<?php

namespace AKlump\LoftLib\Dates;

class ParseMonths {

  /**
   * Parse a date description for all month numbers.
   *
   * @param string $date_description This is case-insensitive and will look for
   * the three letter month abbreviation, so full names will work.  Also
   * supports "monthly", "every month", "each month", "jan", "jan.", "january".
   *
   * @return int[]
   */
  public function __invoke(string $date_description): array {
    $monthly_flag = (bool) preg_match('#monthly|every month#i', $date_description);
    if ($monthly_flag) {
      return range(1, 12);
    }
    preg_match_all('#jan|feb|mar|apr|may|jun|jul|aug|sep|oct|nov|dec#i', $date_description, $matches, PREG_PATTERN_ORDER);
    $map = [];
    for ($i = 1; $i <= 12; $i++) {
      $map[$i] = strtolower(date_create("2024-$i-15")->format('M'));
    }
    $matches[0] = array_map('strtolower', $matches[0]);
    $numbers = array_intersect($map, $matches[0]);

    return array_keys($numbers);
  }

}
