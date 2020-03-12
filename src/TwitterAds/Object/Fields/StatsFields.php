<?php

namespace Hborras\TwitterAdsSDK\TwitterAds\Object\Fields;

use Hborras\TwitterAdsSDK\TwitterAds\Enum\AbstractEnum;

class StatsFields extends AbstractEnum
{

    const END_TIME      = 'end_time';
    const ENTITY        = 'entity';
    const ENTITY_IDS    = 'entity_ids';
    const GRANULARITY   = 'granularity';
    const METRIC_GROUPS = 'metric_groups';
    const PLACEMENT     = 'placement';
    const START_TIME    = 'start_time';

    public function getFieldTypes()
    {

    }
}