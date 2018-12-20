<?php

namespace Hborras\TwitterAdsSDK\TwitterAds\Account;


use Hborras\TwitterAdsSDK\TwitterAds\Campaign\Exception\FeatureKeyNotFoundException;
use Hborras\TwitterAdsSDK\TwitterAds\Fields\FeatureFields;

class Feature
{
    /** @var string  */
    private $featureKey;

    /**
     * Features constructor.
     * @param string $featureKey
     */
    public function __construct(string $featureKey)
    {
        if(!in_array($featureKey, FeatureFields::FEATURES)){
            throw new FeatureKeyNotFoundException();
        }
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