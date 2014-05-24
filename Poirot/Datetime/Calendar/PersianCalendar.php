<?php
namespace Poirot\Datetime\Calendar;

use Poirot\Datetime\CalendarInterval;
use Poirot\Datetime\LocalizeCalendar;

/**
 * Class PersianCalendar
 *
 * @package Poirot\Datetime\Calendar
 */
class PersianCalendar extends LocalizeCalendar
{
    protected $name = 'persian';

    protected $dayOfWeeks = array(
        'sat' => array(1, 'شنبه'),
        'sun' => array(2, 'یکشنبه'),
        'mon' => array(3, 'دوشنبه'),
        'tue' => array(4, 'سه شنبه'),
        'wed' => array(5, 'چهارشنبه'),
        'thu' => array(6, 'پنجشنبه'),
        'fri' => array(7, 'جمعه')
    );

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
}
