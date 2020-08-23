<?php


namespace Hborras\TwitterAdsSDK\TwitterAds\Object\Values;


use Hborras\TwitterAdsSDK\TwitterAds\Enum\AbstractEnum;

class PlacementValues extends AbstractEnum
{
    const ALL_ON_TWITTER     = 'ALL_ON_TWITTER';
    const PUBLISHER_NETWORK  = 'PUBLISHER_NETWORK';
    const TAP_FULL           = 'TAP_FULL';
    const TAP_FULL_LANDSCAPE = 'TAP_FULL_LANDSCAPE';
    const TAP_BANNER         = 'TAP_BANNER';
    const TAP_NATIVE         = 'TAP_NATIVE';
    const TAP_MRECT          = 'TAP_MRECT';
}