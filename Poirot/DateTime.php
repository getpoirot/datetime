<?php
namespace Poirot;

use \DateTime as SplDateTime;
use Poirot\DateTime\Calendar\CalendarInterface;

/**
 * Class DateTime
 *
 * @package Poirot
 */
class DateTime extends SplDateTime
{
    /**
     * @var CalendarInterface
     */
    protected $calendar;

    /**
     * Returns date formatted according to given format.
     *
     * @param string $format
     *
     * @return string
     *
     * @link http://php.net/manual/en/datetime.format.php
     */
    public function format($format)
    {
        if (!$this->getCalendar()) {
            // use default system format output
            return parent::format($format);
        }

        // Request format characters string
        $reqFormat  = (preg_match_all('/([a-zA-Z])/', $format, $chars)) ? $chars[0] : array();

        // Convert date by year/month/day to calendar date system {
        $year  = (int) parent::format('Y');
        $month = (int) parent::format('n');
        $day   = (int) parent::format('j');

        $calInterval = $this->getCalendar()->calculateDate($year, $month, $day);
        if ($calInterval) {
            // change to calendar system
            $year  = $calInterval->year;
            $month = $calInterval->month;
            $day   = $calInterval->day;
        }
        // ... }

        $calendar = $this->getCalendar();
        $replacedKv = array(); // replaced key value with equal format character
        $val = '';
        foreach($reqFormat as $fchar) {
            switch ($fchar) {
                case 'd':
                    $val = sprintf('%02d', $day);
                    break;
                case 'D':
                    $val = $calendar->getWeekDayNamesNarrow(parent::format('D'));
                    break;
                case 'j':
                    $val = $day;
                    break;
                case 'l':
                    $val = $calendar->getWeekDayNames(parent::format('D'));
                    break;
                case 'S':
                    $val = $calendar->getMonthSuffix();
                    $val = ($val) ? $val : parent::format('S');
                    break;
                case 'w': // start week from 0
                    $weekDayNames = $calendar->getWeekDayNames();
                    $dayOfWeek    = strtolower(parent::format('D'));

                    $i = 0;
                    foreach($weekDayNames as $globalName => $localeName) {
                        if ($globalName == $dayOfWeek)
                            break;
                        $i ++;
                    }

                    $val = $i;
                    break;
                case 'z':
                    $val = $calendar->calculateDayOfYear($month, $day);
                    $val = ($val) ? $val : parent::format('z');
                    break;
                case 'W':
                    $val = is_int((int)$this->format('z') / 7) ? ((int)$this->format('z') / 7) : intval((int)$this->format('z') / 7 + 1);
                    break;
                case 'F':
                    $val = $calendar->getMonthNames($month);
                    break;
                case 'm':
                    $val = sprintf('%02d', $month);
                    break;
                case 'M':
                    $val = $calendar->getMonthNamesNarrow($month);
                    break;
                case 'n':
                    $val = $month;
                    break;
                case 't':
                    $val = $calendar->getNumberOfDaysInMonth($month, $year);
                    $val = ($val) ? $val : parent::format('t');
                    break;
                case 'L': /* @TODO: Must test */
                    $tmpObj = new DateTime('@'.(time()-31536000));
                    $val = $tmpObj->format('L');
                    break;
                case 'o':
                case 'Y':
                    $val = $year;
                    break;
                case 'y':
                    $val = $year % 100;
                    break;
                //Time
                case 'a':
                    $val = $calendar->getDayPeriodsNarrow(parent::format('a'));
                    break;
                case 'A':
                    $val = $calendar->getDayPeriods(parent::format('A'));
                    break;
                //Full Dates
                case 'c':
                    $val  = $year.'-'.$this->format('m').'-'.$this->format('d').'T';
                    $val .= parent::format('H').':'.parent::format('i').':'.parent::format('s').parent::format('P');
                    break;
                case 'r':
                    $val  = $this->format('l').', '.$this->format('d').' '.$this->format('M');
                    $val .= ' '.$year.' '.parent::format('H').':'.parent::format('i').':'.parent::format('s').' '.parent::format('P');
                    break;
                //Timezone
                case 'e':
                    $val = parent::format('e');
                    break;
                case 'T':
                    $val = parent::format('T');
                    break;
                default:
                    $val = parent::format($fchar);
            }

            $replacedKv[$fchar] = $val;
        }

        $return = strtr($format, $replacedKv);

        return $return;
    }

    /**
     * Set Calendar system
     *
     * @param CalendarInterface $calendar
     *
     * @return $this
     */
    public function setCalendar(CalendarInterface $calendar)
    {
        $this->calendar = $calendar;

        return $this;
    }

    /**
     * Get Calendar system instance
     *
     * @return CalendarInterface
     */
    public function getCalendar()
    {
        return $this->calendar;
    }
}
