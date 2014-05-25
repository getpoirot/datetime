<?php
namespace Poirot\Datetime\Calendar;

/**
 * Interface CalendarInterface
 *
 * @package Poirot\Datetime
 */
interface CalendarInterface
{
    /**
     * Get calendar system name
     * exp. gregorian
     *
     * @return string
     */
    public function getName();

    /**
     * Get array of narrow textual representation of a day
     * sorted by first day of week to end.
     *
     * @param string|int $day (string)Mon through Sun|(int) 1 for Monday through 7
     *
     * @return array|string
     */
    public function getWeekDayNamesNarrow($day = null);

    /**
     * Get array of textual representation of a day
     * sorted by first day of week to end.
     *
     * @param string|int $day (string)Mon through Sun|(int) 1 for Monday through 7
     *
     * @return array|string
     */
    public function getWeekDayNames($day = null);

    /**
     * Short textual representation of a month, such as January or March
     *
     * @param int $month
     *
     * @return array|string
     */
    public function getMonthNamesNarrow($month = null);

    /**
     * Full textual representation of a month, such as January or March
     *
     * @param int $month
     *
     * @return array|string
     */
    public function getMonthNames($month = null);

    /**
     * Get day periods narrow name
     *
     * @param string|null $val am pm
     *
     * @return array|string
     */
    public function getDayPeriodsNarrow($val = null);

    /**
     * Get day periods name
     *
     * @param string|null $val am pm
     *
     * @return array|string
     */
    public function getDayPeriods($val = null);

    /**
     * Calculate date to calendar system
     *
     * @param int $gYear  Year in gregorian system
     * @param int $gMonth Month in gregorian system
     * @param int $gDay   Day in gregorian system
     *
     * @return CalendarInterval|false
     */
    public function calculateDate($gYear, $gMonth, $gDay);
}
