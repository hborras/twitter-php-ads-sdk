<?php

namespace Hborras\TwitterAdsSDK\TwitterAds\Campaign;

use Hborras\TwitterAdsSDK\TwitterAds\Cursor;
use Hborras\TwitterAdsSDK\TwitterAdsException;
use Hborras\TwitterAdsSDK\TwitterAds\Analytics;
use Hborras\TwitterAdsSDK\TwitterAds\Analytics\Job;
use Hborras\TwitterAdsSDK\TwitterAds\Errors\BadRequest;
use Hborras\TwitterAdsSDK\TwitterAds\Fields\LineItemFields;
use Hborras\TwitterAdsSDK\TwitterAds\Creative\PromotedTweet;
use Hborras\TwitterAdsSDK\TwitterAds\Fields\AnalyticsFields;

/**
 * Class LineItem
 * @package Hborras\TwitterAdsSDK\TwitterAds\Campaign
 */
class LineItem extends Analytics
{
    const RESOURCE_COLLECTION = 'accounts/{account_id}/line_items';
    const RESOURCE            = 'accounts/{account_id}/line_items/{id}';

    const ENTITY = 'LINE_ITEM';

    /** Read Only */
    protected $id;
    protected $created_at;
    protected $updated_at;
    protected $deleted;
    protected $target_cpa_local_micro;
    protected $currency;

    protected $properties = [
        LineItemFields::CAMPAIGN_ID,
        LineItemFields::BID_AMOUNT_LOCAL_MICRO,
        LineItemFields::NAME,
        LineItemFields::BID_TYPE,
        LineItemFields::AUTOMATICALLY_SELECT_BID,
        LineItemFields::PRODUCT_TYPE,
        LineItemFields::PLACEMENTS,
        LineItemFields::OBJECTIVE,
        LineItemFields::ENTITY_STATUS,
        LineItemFields::INCLUDE_SENTIMENT,
        LineItemFields::TOTAL_BUDGET_AMOUNT_LOCAL_MICRO,
        LineItemFields::START_TIME,
        LineItemFields::END_TIME,
        LineItemFields::PRIMARY_WEB_EVENT_TAG,
        LineItemFields::OPTIMIZATION,
        LineItemFields::BID_UNIT,
        LineItemFields::CHARGE_BY,
        LineItemFields::ADVERTISER_DOMAIN,
        LineItemFields::ADVERTISER_USER_ID,
        LineItemFields::CATEGORIES
    ];

    /** Writable */
    protected $campaign_id;
    protected $bid_amount_local_micro;
    protected $name;
    protected $bid_type;
    protected $automatically_select_bid;
    protected $product_type;
    protected $placements;
    protected $objective;
    protected $entity_status;
    protected $include_sentiment;
    protected $total_budget_amount_local_micro;
    protected $start_time;
    protected $end_time;
    protected $primary_web_event_tag;
    protected $optimization;
    protected $bid_unit;
    protected $charge_by;
    protected $advertiser_domain;
    protected $tracking_tags;
    protected $advertiser_user_id;
    protected $categories;

    /**
     * @param array $params
     * @return Cursor|\Hborras\TwitterAdsSDK\TwitterAds\Resource
     * @throws BadRequest
     * @throws TwitterAdsException
     * @throws \Hborras\TwitterAdsSDK\TwitterAds\Errors\Forbidden
     * @throws \Hborras\TwitterAdsSDK\TwitterAds\Errors\NotAuthorized
     * @throws \Hborras\TwitterAdsSDK\TwitterAds\Errors\NotFound
     * @throws \Hborras\TwitterAdsSDK\TwitterAds\Errors\RateLimit
     * @throws \Hborras\TwitterAdsSDK\TwitterAds\Errors\ServerError
     * @throws \Hborras\TwitterAdsSDK\TwitterAds\Errors\ServiceUnavailable
     */
    public function getPromotedTweets($params = [])
    {
        $params[LineItemFields::LINE_ITEM_IDS] = $this->getId();
        $promotedTweetClass = new PromotedTweet();
        return $promotedTweetClass->loadResource('', $params);
    }

    /**
     * @param $metricGroups
     * @param array $params
     * @param bool $async
     * @return Job| mixed
     * @throws BadRequest
     * @throws TwitterAdsException
     * @throws \Hborras\TwitterAdsSDK\TwitterAds\Errors\Forbidden
     * @throws \Hborras\TwitterAdsSDK\TwitterAds\Errors\NotAuthorized
     * @throws \Hborras\TwitterAdsSDK\TwitterAds\Errors\NotFound
     * @throws \Hborras\TwitterAdsSDK\TwitterAds\Errors\RateLimit
     * @throws \Hborras\TwitterAdsSDK\TwitterAds\Errors\ServerError
     * @throws \Hborras\TwitterAdsSDK\TwitterAds\Errors\ServiceUnavailable
     */
    public function stats($metricGroups, $params = [], $async = false)
    {
        $params[AnalyticsFields::ENTITY] = AnalyticsFields::LINE_ITEM;
        return parent::stats($metricGroups, $params, $async);
    }

    /**
     * Returns a collection of targeting criteria available to the
     * current line item.
     *
     * @param string $id
     * @param array $params
     *
     * @return Cursor | Resource
     *
     * @throws TwitterAdsException
     */
    public function getTargetingCriteria($id = '', $params = [])
    {
        $targetingCriteria = new TargetingCriteria();

        $this->validateLoaded();
        if ($id == '') {
            $cursor = $targetingCriteria->line_item_all($this->getId(), $params);
        } else {
            $cursor = $targetingCriteria->load($id, $params);
        }

        return $cursor;
    }

    /**
     * @return mixed
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @return mixed
     */
    public function getCreatedAt()
    {
        return $this->created_at;
    }

    /**
     * @return mixed
     */
    public function getUpdatedAt()
    {
        return $this->updated_at;
    }

    /**
     * @return mixed
     */
    public function getDeleted()
    {
        return $this->deleted;
    }

    /**
     * @param array $properties
     */
    public function setProperties($properties)
    {
        $this->properties = $properties;
    }

    /**
     * @return mixed
     */
    public function getCampaignId()
    {
        return $this->campaign_id;
    }

    /**
     * @param mixed $campaign_id
     */
    public function setCampaignId($campaign_id)
    {
        $this->campaign_id = $campaign_id;
    }

    /**
     * @return mixed
     */
    public function getBidAmountLocalMicro()
    {
        return $this->bid_amount_local_micro;
    }

    /**
     * @param mixed $bid_amount_local_micro
     */
    public function setBidAmountLocalMicro($bid_amount_local_micro)
    {
        $this->bid_amount_local_micro = $bid_amount_local_micro;
    }

    /**
     * @return mixed
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * @param mixed $name
     */
    public function setName($name)
    {
        $this->name = $name;
    }

    /**
     * @return mixed
     */
    public function getBidType()
    {
        return $this->bid_type;
    }

    /**
     * @param mixed $bid_type
     */
    public function setBidType($bid_type)
    {
        $this->bid_type = $bid_type;
    }

    /**
     * @return mixed
     */
    public function getAutomaticallySelectdBid()
    {
        return $this->automatically_select_bid;
    }

    /**
     * @param mixed $automatically_select_bid
     */
    public function setAutomaticallySelectBid($automatically_select_bid)
    {
        $this->automatically_select_bid = $automatically_select_bid;
    }

    /**
     * @return mixed
     */
    public function getProductType()
    {
        return $this->product_type;
    }

    /**
     * @param mixed $product_type
     */
    public function setProductType($product_type)
    {
        $this->product_type = $product_type;
    }

    /**
     * @return mixed
     */
    public function getPlacements()
    {
        return $this->placements;
    }

    /**
     * @param mixed $placements
     */
    public function setPlacements($placements)
    {
        $this->placements = $placements;
    }

    /**
     * @return mixed
     */
    public function getObjective()
    {
        return $this->objective;
    }

    /**
     * @param mixed $objective
     */
    public function setObjective($objective)
    {
        $this->objective = $objective;
    }

    /**
     * @return mixed
     */
    public function getEntityStatus()
    {
        return $this->entity_status;
    }

    /**
     * @param mixed $entity_status
     */
    public function setEntityStatus($entity_status)
    {
        $this->entity_status = $entity_status;
    }

    /**
     * @return mixed
     */
    public function getIncludeSentiment()
    {
        return $this->include_sentiment;
    }

    /**
     * @param mixed $include_sentiment
     */
    public function setIncludeSentiment($include_sentiment)
    {
        $this->include_sentiment = $include_sentiment;
    }

    /**
     * @return mixed
     */
    public function getTotalBudgetAmountLocalMicro()
    {
        return $this->total_budget_amount_local_micro;
    }

    /**
     * @param mixed $total_budget_amount_local_micro
     */
    public function setTotalBudgetAmountLocalMicro($total_budget_amount_local_micro)
    {
        $this->total_budget_amount_local_micro = $total_budget_amount_local_micro;
    }

    /**
     * @return mixed
     */
    public function getStartTime()
    {
        return $this->start_time;
    }

    /**
     * @param mixed $start_time
     */
    public function setStartTime($start_time)
    {
        $this->start_time = $start_time;
    }

    /**
     * @return mixed
     */
    public function getEndTime()
    {
        return $this->end_time;
    }

    /**
     * @param mixed $end_time
     */
    public function setEndTime($end_time)
    {
        $this->end_time = $end_time;
    }

    /**
     * @return mixed
     */
    public function getPrimaryWebEventTag()
    {
        return $this->primary_web_event_tag;
    }

    /**
     * @param mixed $primary_web_event_tag
     */
    public function setPrimaryWebEventTag($primary_web_event_tag)
    {
        $this->primary_web_event_tag = $primary_web_event_tag;
    }

    /**
     * @return mixed
     */
    public function getOptimization()
    {
        return $this->optimization;
    }

    /**
     * @param mixed $optimization
     */
    public function setOptimization($optimization)
    {
        $this->optimization = $optimization;
    }

    /**
     * @return mixed
     */
    public function getBidUnit()
    {
        return $this->bid_unit;
    }

    /**
     * @param mixed $bid_unit
     */
    public function setBidUnit($bid_unit)
    {
        $this->bid_unit = $bid_unit;
    }

    /**
     * @return mixed
     */
    public function getChargeBy()
    {
        return $this->charge_by;
    }

    /**
     * @param mixed $charge_by
     */
    public function setChargeBy($charge_by)
    {
        $this->charge_by = $charge_by;
    }

    /**
     * @return mixed
     */
    public function getAdvertiserDomain()
    {
        return $this->advertiser_domain;
    }

    /**
     * @param mixed $advertiser_domain
     */
    public function setAdvertiserDomain($advertiser_domain)
    {
        $this->advertiser_domain = $advertiser_domain;
    }

    /**
     * @return mixed
     */
    public function getTrackingTags()
    {
        return $this->tracking_tags;
    }

    /**
     * @param mixed $tracking_tags
     */
    public function setTrackingTags($tracking_tags)
    {
        $this->tracking_tags = $tracking_tags;
    }

    /**
     * @return mixed
     */
    public function getAdvertiserUserId()
    {
        return $this->advertiser_user_id;
    }

    /**
     * @param mixed $advertiser_user_id
     */
    public function setAdvertiserUserId($advertiser_user_id)
    {
        $this->advertiser_user_id = $advertiser_user_id;
    }

    /**
     * @return mixed
     */
    public function getTargetCpaLocalMicro()
    {
        return $this->target_cpa_local_micro;
    }

    /**
     * @return mixed
     */
    public function getAutomaticallySelectBid()
    {
        return $this->automatically_select_bid;
    }

    /**
     * @return mixed
     */
    public function getCategories()
    {
        return $this->categories;
    }

    /**
     * @param mixed $categories
     */
    public function setCategories($categories)
    {
        $this->categories = $categories;
    }

    /**
     * @return mixed
     */
    public function getCurrency()
    {
        return $this->currency;
    }
}
