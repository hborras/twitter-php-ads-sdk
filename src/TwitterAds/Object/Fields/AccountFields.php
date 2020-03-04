<?php

namespace Hborras\TwitterAdsSDK\TwitterAds\Object\Fields;

use Hborras\TwitterAdsSDK\TwitterAds\Enum\AbstractEnum;

class AccountFields extends AbstractEnum
{
    const ID                 = 'id';
    const SALT               = 'salt';
    const NAME               = 'name';
    const TIMEZONE           = 'timezone';
    const TIMEZONE_SWITCH_AT = 'timezone_switch_at';
    const CREATED_AT         = 'created_at';
    const UPDATED_AT         = 'updated_at';
    const DELETED            = 'deleted';
    const APPROVAL_STATUS    = 'approval_status';
    const USER_IDS           = 'user_ids';
    const WITH_TOTAL_COUNT   = 'with_total_count';
    const BUSINESS_NAME      = 'business_name';
    const BUSINESS_ID        = 'business_id';
    const INDUSTRY_TYPE      = 'industry_type';

    const ACCOUNT_IDS        = 'account_ids';

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