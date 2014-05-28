<?php
namespace Poirot\DateTime\Calendar;
use Poirot\DateTime\CalendarInterval;

/**
 * Interface CalendarInterface
 *
 * @package Poirot\DateTime
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
     * English ordinal suffix for the day of the month, 2 characters
     * exp. st, nd, rd or th. Works well with j char format
     * @note return null if there is no specific suffix
     *
     * @return string|null
     */
    public function getMonthSuffix();

    /**
     * Number of days in the given month
     *
     * @param int $month Month
     * @param int $year  Year
     *
     * @return int
     */
    public function getNumberOfDaysInMonth($month, $year);

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

    /**
     * Which The day of the year (starting from 0)
     * exp. 0 through 365
     * @note return null mean datetime must use default value
     *
     * @return int|null
     */
    public function calculateDayOfYear($month, $day);
}
