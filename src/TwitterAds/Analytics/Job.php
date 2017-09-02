<?php
/**
 * Created by PhpStorm.
 * User: hborras
 * Date: 3/04/16
 * Time: 11:59.
 */
namespace Hborras\TwitterAdsSDK\TwitterAds\Campaign;

use Hborras\TwitterAdsSDK\TwitterAds\Analytics;
use Hborras\TwitterAdsSDK\TwitterAds\Enumerations;
use Hborras\TwitterAdsSDK\TwitterAds\Fields\AnalyticsFields;
use Hborras\TwitterAdsSDK\TwitterAds\Fields\CampaignFields;

class Job extends Analytics
{
    const RESOURCE_COLLECTION = 'stats/jobs/accounts/{account_id}';
    const ENTITY              = 'JOBS';

    /** Read Only */
    protected $id;
    protected $reasons_not_servable;
    protected $servable;
    protected $created_at;
    protected $updated_at;
    protected $deleted;
    protected $currency;
    protected $entity_status;

    protected $properties = [];

    /** Writable */
    protected $name;
    protected $funding_instrument_id;
    protected $start_time;
    protected $end_time;
    protected $paused;
    protected $standard_delivery;
    protected $daily_budget_amount_local_micro;
    protected $total_budget_amount_local_micro;
    protected $duration_in_days;
    protected $frequency_cap;

}
