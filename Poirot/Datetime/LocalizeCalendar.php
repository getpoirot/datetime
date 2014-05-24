<?php
namespace Poirot\Datetime;

/**
 * Class LocalizeCalendar
 *
 * @package Poirot\Datetime
 */
class LocalizeCalendar implements CalendarInterface
{
    protected $name = 'gregorian';

    /**
     * Get calendar system name
     * exp. gregorian
     *
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * Calculate date to calendar system
     *
     * @param int $gYear Year in gregorian system
     * @param int $gMonth Month in gregorian system
     * @param int $gDay Day in gregorian system
     *
     * @return CalendarInterval|false
     */
    public function calculateDate($gYear, $gMonth, $gDay)
    {
        return false;
    }

    /**
     * Get array of narrow textual representation of a day
     * sorted by first day of week to end.
     *
     * @param string|int $day (string)Mon through Sun|(int) 1 for Monday through 7
     *
     * @return array|string
     */
    public function getWeekDayNamesNarrow($day = null)
    {
        // TODO: Implement getWeekDayNamesNarrow() method.
    }

    /**
     * Get array of textual representation of a day
     * sorted by first day of week to end.
     *
     * @param string|int $day (string)Mon through Sun|(int) 1 for Monday through 7
     *
     * @return array|string
     */
    public function getWeekDayNames($day = null)
    {
        // TODO: Implement getWeekDayNames() method.
    }
}
