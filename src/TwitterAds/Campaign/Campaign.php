<?php
/**
 * Created by PhpStorm.
 * User: hborras
 * Date: 3/04/16
 * Time: 11:59.
 */
namespace Hborras\TwitterAdsSDK\TwitterAds\Campaign;

use Hborras\TwitterAdsSDK\TwitterAds\Analytics;
use Hborras\TwitterAdsSDK\TwitterAds\Resource;

class Campaign extends Resource
{
    const RESOURCE_COLLECTION = 'accounts/{account_id}/campaigns';
    const RESOURCE = 'accounts/{account_id}/campaigns/{id}';

    /** Read Only */
    protected $id;
    protected $reasons_not_servable;
    protected $servable;
    protected $created_at;
    protected $updated_at;
    protected $deleted;

    protected $properties = [
        'name',
        'funding_instrument_id',
        'start_time',
        'end_time',
        'paused',
        'currency',
        'standard_delivery',
        'daily_budget_amount_local_micro',
        'total_budget_amount_local_micro',
    ];

    /** Writable */
    protected $name;
    protected $funding_instrument_id;
    protected $start_time;
    protected $end_time;
    protected $paused;
    protected $currency;
    protected $standard_delivery;
    protected $daily_budget_amount_local_micro;
    protected $total_budget_amount_local_micro;

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
    public function getPaused()
    {
        return $this->paused;
    }

    /**
     * @param mixed $paused
     */
    public function setPaused($paused)
    {
        $this->paused = $paused;
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
}
