<?php

namespace Hborras\TwitterAdsSDK\TwitterAds\Account;


class Feature
{
    const FEATURE_KEYS = [
        
    ];

    /** @var string  */
    private $featureKey;

    /**
     * Feature constructor.
     * @param string $featureKey
     */
    public function __construct(string $featureKey)
    {
        $this->featureKey = $featureKey;
    }

    /**
     * @return string
     */
    public function featureKey()
    {
        return $this->featureKey;
    }
}