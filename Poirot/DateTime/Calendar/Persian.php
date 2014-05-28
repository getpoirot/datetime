<?php
namespace Poirot\DateTime\Calendar;

use Poirot\DateTime\CalendarInterval;

/**
 * Class PersianCalendar
 *
 * @package Poirot\DateTime\Calendar
 */
class Persian implements CalendarInterface
{
    protected $name = 'persian';

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
     * English ordinal suffix for the day of the month, 2 characters
     * exp. st, nd, rd or th. Works well with j char format
     * @note return null if there is no specific suffix
     *
     * @return string|null
     */
    public function getMonthSuffix()
    {
        return 'ام';
    }

    /**
     * Number of days in the given month
     *
     * @param int $month Month
     * @param int $year Year
     *
     * @return int
     */
    public function getNumberOfDaysInMonth($month, $year)
    {
        $return = null;

        if ($month >= 1 && $month <= 6) $return = 31;
        else if ($month >= 7 && $month <= 11) $return = 30;
        else if($month == 12 && $year % 4 ==3) $return = 30;
        else if ($month == 12 && $year % 4 !=3) $return = 29;

        return $return;
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
        $dayOfWeeks = array(
            'sat' => 'ش',
            'sun' => 'ی',
            'mon' => 'د',
            'tue' => 'س',
            'wed' => 'چ',
            'thu' => 'پ',
            'fri' => 'ج'
        );

        $return = ($day == null) ? $dayOfWeeks : false;

        $day = (is_string($day)) ? strtolower($day) : $day;

        if (is_string($day) && isset($dayOfWeeks[$day])) {
            $return = $dayOfWeeks[$day];
        } elseif(is_int($day)) {
            // get with index
            $arrayKeys = array_keys($dayOfWeeks);
            $return    = $dayOfWeeks[$arrayKeys[$day]];
        }

        return $return;
    }

    /**
     * Get array of textual representation of a day
     * sorted by first day of week to end.
     *
     * @param string|int $day (string)Mon through Sun|(int) 1 for Monday through 7
     *
     * @return array|string|false
     */
    public function getWeekDayNames($day = null)
    {
        $dayOfWeeks = array(
            'sat' => 'شنبه',
            'sun' => 'یکشنبه',
            'mon' => 'دوشنبه',
            'tue' => 'سه شنبه',
            'wed' => 'چهارشنبه',
            'thu' => 'پنجشنبه',
            'fri' => 'جمعه'
        );

        $return = ($day == null) ? $dayOfWeeks : false;

        $day = (is_string($day)) ? strtolower($day) : $day;

        if (is_string($day) && isset($dayOfWeeks[$day])) {
            $return = $dayOfWeeks[$day];
        } elseif(is_int($day)) {
            // get with index
            $arrayKeys = array_keys($dayOfWeeks);
            $return    = $dayOfWeeks[$arrayKeys[$day]];
        }

        return $return;
    }

    /**
     * Short textual representation of a month, such as January or March
     *
     * @param int $month
     *
     * @return array|string
     */
    public function getMonthNamesNarrow($month = null)
    {
        return $this->getMonthNames($month);
    }

    /**
     * Full textual representation of a month, such as January or March
     *
     * @param int $month
     *
     * @return array|string
     */
    public function getMonthNames($month = null)
    {
        $month = $month-1;

        $months = array(
            'فروردین', 'اردیبهشت', 'خرداد', 'تیر', 'مرداد', 'شهریور', 'مهر', 'آبان', 'آذر', 'دی', 'بهمن', 'اسفند'
        );

        $return = ($month == null) ? $months : false;

        return isset($months[$month]) ? $months[$month] : $return;
    }

    /**
     * Get day periods narrow name
     *
     * @param string|null $val am pm
     *
     * @return array|string
     */
    public function getDayPeriodsNarrow($val = null)
    {
        $val = strtolower($val);

        return ($val == 'am') ? 'ق.ظ'
            : ($val == 'pm') ? 'ب.ظ' : false;
    }

    /**
     * Get day periods name
     *
     * @param string|null $val am pm
     *
     * @return array|string
     */
    public function getDayPeriods($val = null)
    {
        $val = strtolower($val);

        return ($val == 'am') ? 'قبل از ظهر'
            : ($val == 'pm') ? 'بعد از ظهر' : false;
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
        $g_days_in_month = array(31, 28, 31, 30, 31, 30, 31, 31, 30, 31, 30, 31);
        $j_days_in_month = array(31, 31, 31, 31, 31, 31, 30, 30, 30, 30, 30, 29);

        $gy = $gYear-1600;
        $gm = $gMonth-1;
        $gd = $gDay-1;

        $g_day_no = 365*$gy+self::div($gy+3, 4)-self::div($gy+99, 100)+self::div($gy+399, 400);

        for ($i=0; $i < $gm; ++$i)
            $g_day_no += $g_days_in_month[$i];
        if ($gm>1 && (($gy%4==0 && $gy%100!=0) || ($gy%400==0)))
            $g_day_no++;
        $g_day_no += $gd;

        $j_day_no = $g_day_no-79;

        $j_np = self::div($j_day_no, 12053);
        $j_day_no = $j_day_no % 12053;

        $jy = 979+33*$j_np+4*self::div($j_day_no, 1461);

        $j_day_no %= 1461;

        if ($j_day_no >= 366) {
            $jy += self::div($j_day_no-1, 365);
            $j_day_no = ($j_day_no-1)%365;
        }

        for ($i = 0; $i < 11 && $j_day_no >= $j_days_in_month[$i]; ++$i)
            $j_day_no -= $j_days_in_month[$i];
        $jm = $i+1;
        $jd = $j_day_no+1;

        return new CalendarInterval($jy, $jm, $jd);
    }

    /**
     * Division
     *
     * @param int $a
     * @param int $b
     *
     * @return int
     */
    private static function div($a, $b)
    {
        return (int) ($a / $b);
    }

    /**
     * Which The day of the year (starting from 0)
     * exp. 0 through 365
     * @note return null mean datetime must use default value
     *
     * @return int|null
     */
    public function calculateDayOfYear($month, $day)
    {
        if ($month > 6) {
            $return = 186 + (($month - 6 - 1) * 30) + $day;
        } else {
            $return = (($month - 1) * 31) + $day;
        }

        return $return;
    }
}
