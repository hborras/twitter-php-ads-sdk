<?php
/**
 * Created by PhpStorm.
 * User: hborras
 * Date: 3/04/16
 * Time: 11:59.
 */
namespace Hborras\TwitterAdsSDK\TwitterAds\Campaign;

use Hborras\TwitterAdsSDK\TwitterAds\Analytics;
use Hborras\TwitterAdsSDK\TwitterAds\Cursor;
use Hborras\TwitterAdsSDK\TwitterAdsException;

class LineItem extends Analytics
{
    const RESOURCE_COLLECTION = 'accounts/{account_id}/line_items';
    const RESOURCE            = 'accounts/{account_id}/line_items/{id}';

    const ENTITY = "LINE_ITEM";

    /** Read Only */
    protected $id;
    protected $created_at;
    protected $updated_at;
    protected $deleted;

    protected $properties = [
        'campaign_id',
        'bid_amount_local_micro',
        'name',
        'bid_type',
        'automatically_selected_bid',
        'product_type',
        'placements',
        'objective',
        'paused',
        'include_sentiment',
        'total_budget_amount_local_micro',
        'start_time',
        'end_time',
        'primary_web_event_tag',
        'optimization',
        'bid_unit',
        'charge_by',
        'advertiser_domain',
        'advertiser_user_id',
    ];

    /** Writable */
    protected $campaign_id;
    protected $bid_amount_local_micro;
    protected $name;
    protected $bid_type;
    protected $automatically_selected_bid;
    protected $product_type;
    protected $placements;
    protected $objective;
    protected $paused;
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

    /**
     * Returns a collection of targeting criteria available to the
     * current line item.
     *
     * @param string $id
     * @param array $params
     *
     * @return Cursor
     *
     * @throws TwitterAdsException
     */
    public function getTargetingCriteria($id = '', $params = [])
    {
        $targetingCriteria = new TargetingCriteria();
        $targetingCriteria->setAccount($this->getAccount());

        $this->validateLoaded();
        if ($id == '') {
            $cursor = $targetingCriteria->all($this->getId(), $params);
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
    public function getAutomaticallySelectedBid()
    {
        return $this->automatically_selected_bid;
    }

    /**
     * @param mixed $automatically_selected_bid
     */
    public function setAutomaticallySelectedBid($automatically_selected_bid)
    {
        $this->automatically_selected_bid = $automatically_selected_bid;
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
}
