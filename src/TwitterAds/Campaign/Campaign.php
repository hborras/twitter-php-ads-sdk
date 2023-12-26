<?php

namespace Hborras\TwitterAdsSDK\TwitterAds\Campaign;

use DateTime;
use Hborras\TwitterAdsSDK\TwitterAds\Cursor;
use Hborras\TwitterAdsSDK\TwitterAds\Analytics;
use Hborras\TwitterAdsSDK\TwitterAds\Errors\BadRequest;
use Hborras\TwitterAdsSDK\TwitterAds\Fields\CampaignFields;
use Hborras\TwitterAdsSDK\TwitterAds\Fields\AnalyticsFields;

/**
 * Class Campaign
 * @package Hborras\TwitterAdsSDK\TwitterAds\Campaign
 */
class Campaign extends Analytics
{
    const RESOURCE_COLLECTION = 'accounts/{account_id}/campaigns';
    const RESOURCE            = 'accounts/{account_id}/campaigns/{id}';
    const ENTITY              = 'CAMPAIGN';

    /** Read Only */
    protected $id;
    protected $reasons_not_servable;
    protected $servable;
    protected $created_at;
    protected $updated_at;
    protected $deleted;
    protected $currency;

    protected $properties = [
        CampaignFields::NAME,
        CampaignFields::FUNDING_INSTRUMENT_ID,
        CampaignFields::BUDGET_OPTIMIZATION,
        CampaignFields::START_TIME,
        CampaignFields::END_TIME,
        CampaignFields::ENTITY_STATUS,
        CampaignFields::STANDARD_DELIVERY,
        CampaignFields::DAILY_BUDGET_AMOUNT_LOCAL_MICRO,
        CampaignFields::TOTAL_BUDGET_AMOUNT_LOCAL_MICRO,
        CampaignFields::DURATION_IN_DAYS,
        CampaignFields::FREQUENCY_CAP,
    ];

    /** Writable */
    protected $name;
    protected $funding_instrument_id;
    protected $start_time;
    protected $end_time;
    protected $entity_status;
    protected $standard_delivery;
    protected $daily_budget_amount_local_micro;
    protected $total_budget_amount_local_micro;
    protected $duration_in_days;
    protected $budget_optimization;
    protected $frequency_cap;

    /**
     * @param array $params
     * @return Cursor|Resource
     * @throws BadRequest
     * @throws \Hborras\TwitterAdsSDK\TwitterAdsException
     * @throws \Hborras\TwitterAdsSDK\TwitterAds\Errors\Forbidden
     * @throws \Hborras\TwitterAdsSDK\TwitterAds\Errors\NotAuthorized
     * @throws \Hborras\TwitterAdsSDK\TwitterAds\Errors\NotFound
     * @throws \Hborras\TwitterAdsSDK\TwitterAds\Errors\RateLimit
     * @throws \Hborras\TwitterAdsSDK\TwitterAds\Errors\ServerError
     * @throws \Hborras\TwitterAdsSDK\TwitterAds\Errors\ServiceUnavailable
     */
    public function getLineItems($params = [])
    {
        $params[CampaignFields::CAMPAIGN_IDS] = $this->getId();
        $lineItemClass = new LineItem();
        return $lineItemClass->loadResource('', $params);
    }

    /**
     * @param $metricGroups
     * @param array $params
     * @param bool $async
     * @return mixed
     * @throws BadRequest
     * @throws \Hborras\TwitterAdsSDK\TwitterAdsException
     * @throws \Hborras\TwitterAdsSDK\TwitterAds\Errors\Forbidden
     * @throws \Hborras\TwitterAdsSDK\TwitterAds\Errors\NotAuthorized
     * @throws \Hborras\TwitterAdsSDK\TwitterAds\Errors\NotFound
     * @throws \Hborras\TwitterAdsSDK\TwitterAds\Errors\RateLimit
     * @throws \Hborras\TwitterAdsSDK\TwitterAds\Errors\ServerError
     * @throws \Hborras\TwitterAdsSDK\TwitterAds\Errors\ServiceUnavailable
     */
    public function stats($metricGroups, $params = [], $async = false)
    {
        $params[AnalyticsFields::ENTITY] = AnalyticsFields::CAMPAIGN;
        return parent::stats($metricGroups, $params, $async);
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
    public function getReasonsNotServable()
    {
        return $this->reasons_not_servable;
    }

    /**
     * @return mixed
     */
    public function getServable()
    {
        return $this->servable;
    }

    /**
     * @return DateTime
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
    public function getFundingInstrumentId()
    {
        return $this->funding_instrument_id;
    }

    /**
     * @param mixed $funding_instrument_id
     */
    public function setFundingInstrumentId($funding_instrument_id)
    {
        $this->funding_instrument_id = $funding_instrument_id;
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
    public function getEntityStatus()
    {
        return $this->entity_status;
    }

    /**
     * @param mixed $entityStatus
     */
    public function setEntityStatus($entityStatus)
    {
        $this->entity_status = $entityStatus;
    }

    /**
     * @return mixed
     */
    public function getCurrency()
    {
        return $this->currency;
    }

    /**
     * @param mixed $currency
     */
    public function setCurrency($currency)
    {
        $this->currency = $currency;
    }

    /**
     * @return mixed
     */
    public function getStandardDelivery()
    {
        return $this->standard_delivery;
    }

    /**
     * @param mixed $standard_delivery
     */
    public function setStandardDelivery($standard_delivery)
    {
        $this->standard_delivery = $standard_delivery;
    }

    /**
     * @return mixed
     */
    public function getBudgetOptimization()
    {
        return $this->budget_optimization;
    }

    /**
     * @param mixed $budget_optimization
     */
    public function setBudgetOptimization($budget_optimization)
    {
        $this->budget_optimization = $budget_optimization;
    }

    /**
     * @return mixed
     */
    public function getDailyBudgetAmountLocalMicro()
    {
        return $this->daily_budget_amount_local_micro;
    }

    /**
     * @param mixed $daily_budget_amount_local_micro
     */
    public function setDailyBudgetAmountLocalMicro($daily_budget_amount_local_micro)
    {
        $this->daily_budget_amount_local_micro = $daily_budget_amount_local_micro;
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
     * @param array $properties
     */
    public function setProperties($properties)
    {
        $this->properties = $properties;
    }

    /**
     * @return mixed
     */
    public function getDurationInDays()
    {
        return $this->duration_in_days;
    }

    /**
     * @param mixed $duration_in_days
     */
    public function setDurationInDays($duration_in_days)
    {
        $this->duration_in_days = $duration_in_days;
    }

    /**
     * @return mixed
     */
    public function getFrequencyCap()
    {
        return $this->frequency_cap;
    }

    /**
     * @param mixed $frequency_cap
     */
    public function setFrequencyCap($frequency_cap)
    {
        $this->frequency_cap = $frequency_cap;
    }
}
