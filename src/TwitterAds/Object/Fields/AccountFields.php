<?php

namespace Hborras\TwitterAdsSDK\TwitterAds\Object\Fields;

use Hborras\TwitterAdsSDK\TwitterAds\Enum\AbstractEnum;

class AccountFields extends AbstractEnum
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

    const ACCOUNT_IDS      = 'account_ids';
    const COUNT            = 'count';
    const CURSOR           = 'cursor';
    const QUERY            = 'q';
    const SORT_BY          = 'sort_by';
    const WITH_DELETED     = 'with_deleted';
    const WITH_TOTAL_COUNT = 'with_total_count';

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