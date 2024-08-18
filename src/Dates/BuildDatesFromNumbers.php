<?php

namespace AKlump\LoftLib\Dates;

use DateTimeZone;

class BuildDatesFromNumbers {

  /**
   * @var \DateTimeZone
   */
  private $timezone;

  public function __construct(DateTimeZone $timezone) {
    $this->timezone = $timezone;
  }

  /**
   * @param int[] $years
   * @param int[] $months
   * @param int[] $days
   *
   * @return \DateTimeInterface[]
   */
  public function __invoke(array $years, array $months, array $days, array $hours, array $minutes, array $seconds): array {
    $dates = [];
    foreach ($years as $year) {
      foreach ($months as $month) {
        foreach ($days as $day) {
          foreach ($hours as $hour) {
            foreach ($minutes as $minute) {
              foreach ($seconds as $second) {
                $date =  date_create($year . '-' . $month . '-' . $day, $this->timezone);
                $dates[] = $date->setTime($hour, $minute, $second);
              }
            }
          }
        }
      }
    }

    return $dates;
  }
}
