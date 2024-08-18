<?php

namespace AKlump\LoftLib\Dates;

use DateTimeInterface;

class FilterDatesByPeriod {

  /**
   * @var \DateTimeInterface
   */
  private $start;

  /**
   * @var \DateTimeInterface
   */
  private $end;

  public function __construct(DateTimeInterface $start, DateTimeInterface $end) {
    $this->start = $start;
    $this->end = $end;
  }

  function __invoke(array $dates) {
    return array_values(array_filter($dates, function ($date) {
      return $date >= $this->start && $date <= $this->end;
    }));
  }

}
