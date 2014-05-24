<?php
namespace Poirot;

use Poirot\Datetime\CalendarInterface;

/**
 * Interface DateTimeInterface
 *
 * @package Poirot
 */
interface DateTimeInterface
{
    /**
     * Reset timestamp of Datetime
     *
     * @param int|string $timestamp Timestamp unix or String datetime format
     *
     * @return $this
     */
    public function setTimestamp($timestamp);

    /**
     * Get unix timestamp
     *
     * @return int
     */
    public function getTimestamp();

    /**
     * Get calendar instance
     *
     * @return CalendarInterface
     */
    public function getCalendar();
}
