<?php

namespace Hborras\TwitterAdsSDK\TwitterAds\Campaign;

use Hborras\TwitterAdsSDK\TwitterAds\Batch;
use Hborras\TwitterAdsSDK\TwitterAds\Fields\AnalyticsFields;
use Hborras\TwitterAdsSDK\TwitterAds\Fields\CampaignFields;

class Campaign extends Batch
{
    const RESOURCE_COLLECTION = 'accounts/{account_id}/campaigns';
    const RESOURCE_BATCH = 'batch/accounts/{account_id}/campaigns';
    const RESOURCE = 'accounts/{account_id}/campaigns/{id}';
    const ENTITY = 'CAMPAIGN';
    const BATCH_SIZE = 20;
    const ENTITY_TYPE = 'campaign';

    const STATUS_ACTIVE = 'ACTIVE';
    const STATUS_PAUSED = 'PAUSED';

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
    protected $frequency_cap;

    /** sdk */
    protected $toDelete;

    /**
     * @param array $params
     * @return \Hborras\TwitterAdsSDK\TwitterAds\Cursor|Resource
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
     * @return \DateTime
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
     * @return array
     */
    public function getProperties()
    {
        return $this->properties;
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

    /**
     * @return mixed
     */
    public function getToDelete()
    {
        return $this->toDelete;
    }

    /**
     * @param mixed $toDelete
     */
    public function setToDelete($toDelete)
    {
        $this->toDelete = $toDelete;
    }
}
