<?php

namespace Hborras\TwitterAdsSDK\DateTime;

use DateTime;
use Exception;
use DateTimeZone;
use DateTimeImmutable;

/**
 * A collection of helper functions for string->date conversion
 *
 * @since 2016-06-24
 */
trait DateTimeFormatter
{
    /**
     * Returns a DateTime object from a date string.
     *
     * @param $datestr
     * @param string $timezone
     * @return DateTime
     * @throws Exception
     */
    public function toDateTime($datestr, $timezone = 'UTC')
    {
        return (new DateTime($datestr))->setTimezone(new DateTimeZone($timezone));
    }

    /**
     * Returns an ImmutableDateTime object from a date string.
     *
     * @param $datestr
     * @param string $timezone
     * @return DateTimeImmutable
     * @throws Exception
     */
    public function toDateTimeImmutable($datestr, $timezone = 'UTC')
    {
        return (new DateTimeImmutable($datestr))->setTimezone(new DateTimeZone($timezone));
    }
}
