<?php

namespace Hborras\TwitterAdsSDK\TwitterAds\Object\Fields;

use Hborras\TwitterAdsSDK\TwitterAds\Enum\AbstractEnum;

class CampaignFields extends AbstractEnum
{
    const NAME                            = 'name';
    const START_TIME                      = 'start_time';
    const REASONS_NOT_SERVABLE            = 'reasons_not_servable';
    const SERVABLE                        = 'servable';
    const DAILY_BUDGET_AMOUNT_LOCAL_MICRO = 'daily_budget_amount_local_micro';
    const END_TIME                        = 'end_time';
    const FUNDING_INSTRUMENT_ID           = 'funding_instrument_id';
    const DURATION_IN_DAYS                = 'duration_in_days';
    const STANDARD_DELIVERY               = 'standard_delivery';
    const TOTAL_BUDGET_AMOUNT_LOCAL_MICRO = 'total_budget_amount_local_micro';
    const ID                              = 'id';
    const ENTITY_STATUS                   = 'entity_status';
    const FREQUENCY_CAP                   = 'frequency_cap';
    const CURRENCY                        = 'currency';
    const CREATED_AT                      = 'created_at';
    const UPDATED_AT                      = 'updated_at';
    const DELETED                         = 'deleted';

    const COUNT        = 'count';
    const CAMPAIGN_IDS = 'campaign_ids';

    public function getFieldTypes()
    {
        return [
            'name' => 'string',
            'start_time' => 'datetime',
            'reasons_not_servable' => 'list',
            'servable' => 'bool',
            'daily_budget_amount_local_micro' => 'int',
            'end_time' => 'datetime',
            'funding_instrument_id' => 'string',
            'duration_in_days' => 'int',
            'standard_delivery' => 'bool',
            'total_budget_amount_local_micro' => 'int',
            'id' => 'string',
            'entity_status' => 'EntityStatus',
            'frequency_cap' => 'int',
            'currency' => 'string',
            'created_at' => 'datetime',
            'updated_at' => 'datetime',
            'deleted' => 'bool',
        ];
    }
}