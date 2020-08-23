<?php

namespace Hborras\TwitterAdsSDK\TwitterAds\Campaign;

use DateTime;
use Hborras\TwitterAdsSDK\TwitterAds\Cursor;
use Hborras\TwitterAdsSDK\TwitterAds\Errors\BadRequest;
use Hborras\TwitterAdsSDK\TwitterAds\Fields\AudienceSummaryFields;
use Hborras\TwitterAdsSDK\TwitterAds\Fields\CampaignFields;
use Hborras\TwitterAdsSDK\TwitterAds\Fields\AnalyticsFields;
use Hborras\TwitterAdsSDK\TwitterAds\Resource;

class AudienceSummary extends Resource
{
    const RESOURCE_COLLECTION = 'accounts/{account_id}/audience_summary';
    const ENTITY              = 'AUDIENCE_SUMMARY';

    /** Read Only */
    protected $audience_size;

    protected $properties = [
        AudienceSummaryFields::TARGETING_CRITERIA,
    ];

    /** Writable */
    protected $targeting_criteria;


    /**
     * @return mixed
     */
    public function getId()
    {
        return null;
    }

    public function getAudienceSsize()
    {
        return $this->audience_size;
    }
}
