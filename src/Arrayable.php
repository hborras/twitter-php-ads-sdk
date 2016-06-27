<?php

namespace Hborras\TwitterAdsSDK;

/**
 * An interface that defines whether or not an object can be transformed to an array
 *
 * @since 2016-06-24
 */
interface Arrayable
{
    /**
     * Returns an array representation of an object
     *
     * @return array
     */
    public function toArray();
}
