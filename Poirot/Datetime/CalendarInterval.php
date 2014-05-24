<?php
namespace Poirot\Datetime;

/**
 * Class CalendarInterval
 *
 * @package Poirot\Datetime
 */
class CalendarInterval
{
    /**
     * @var int
     */
    public $year;

    /**
     * @var int
     */
    public $month;

    /**
     * @var int
     */
    public $day;

    /**
     * Construct
     *
     * @param int $year
     * @param int $month
     * @param int $day
     */
    public function __construct($year, $month, $day)
    {
        $this->year  = $year;
        $this->month = $month;
        $this->day   = $day;
    }
}
