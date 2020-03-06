<?php

namespace Hborras\TwitterAdsSDK\TwitterAds\Object\Fields;

use Hborras\TwitterAdsSDK\TwitterAds\Enum\AbstractEnum;

class AdAccountFields extends AbstractEnum
{
    const NAME               = 'name';
    const BUSINESS_NAME      = 'business_name';
    const TIMEZONE           = 'timezone';
    const TIMEZONE_SWITCH_AT = 'timezone_switch_at';
    const ID                 = 'id';
    const CREATED_AT         = 'created_at';
    const SALT               = 'salt';
    const UPDATED_AT         = 'updated_at';
    const INDUSTRY_TYPE      = 'industry_type';
    const BUSINESS_ID        = 'business_id';
    const APPROVAL_STATUS    = 'approval_status';
    const DELETED            = 'deleted';

    public function getFieldTypes()
    {
        return [
            'name' => 'string',
            'business_name' => 'string',
            'timezone' => 'string',
            'timezone_switch_at' => 'string',
            'id' => 'string',
            'created_at' => 'datetime',
            'salt' => 'string',
            'updated_at' => 'string',
            'business_id' => 'string',
            'approval_status' => 'string',
            'deleted' => 'bool',
        ];
    }
}