<?php

namespace Hborras\TwitterAdsSDK\DateTime;

use DateTime;
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
     * @param string
     * @return DateTime
     */
    public function toDateTime($datestr)
    {
        return (new \DateTime($datestr))->setTimezone(new \DateTimeZone('UTC'));
    }
    /**
     * Returns an ImmutableDateTime object from a date string.
     *
     * @param string
     * @return DateTimeImmutable
     */
    public function toDateTimeImmutable($datestr)
    {
        return (new \DateTimeImmutable($datestr))->setTimezone(new \DateTimeZone('UTC'));
    }
}
