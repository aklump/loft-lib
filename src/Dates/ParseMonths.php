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

    $map = [];
    for ($i = 1; $i <= 12; $i++) {
      $map[$i] = strtolower(date_create("2024-$i-15")->format('M'));
    }

    $numbers = [];
    $pattern = '#(' . implode('|', $map) . ')\s*-\s*(' . implode('|', $map) . ')#i';
    if (preg_match_all($pattern, $date_description, $matches, PREG_SET_ORDER)) {
      foreach ($matches as $match) {
        $start = array_search(strtolower($match[1]), $map);
        $end = array_search(strtolower($match[2]), $map);
        if ($start !== FALSE && $end !== FALSE) {
          $numbers = array_merge($numbers, range($start, $end));
        }
      }
    }

    preg_match_all('#jan|feb|mar|apr|may|jun|jul|aug|sep|oct|nov|dec#i', $date_description, $matches, PREG_PATTERN_ORDER);
    $matches[0] = array_map('strtolower', $matches[0]);
    $numbers = array_merge($numbers, array_keys(array_intersect($map, $matches[0])));

    return array_values(array_unique($numbers));
  }

}
