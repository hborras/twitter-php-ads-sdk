<?php

namespace Hborras\TwitterAdsSDK\TwitterAds\Campaign;

use Hborras\TwitterAdsSDK\TwitterAds\Account\Feature;

class Features
{
    /**
     * @param array $response
     * @return Feature[]
     */
    public static function fromResponse(array $response)
    {
        $features = [];

        foreach ($response as $item) {
            $feature = new Feature($item);
            $features[] = $feature;

        }
        return $features;
    }
}
