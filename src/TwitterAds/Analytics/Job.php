<?php

namespace Hborras\TwitterAdsSDK\TwitterAds\Analytics;

use Hborras\TwitterAdsSDK\TwitterAds\Analytics;
use Hborras\TwitterAdsSDK\TwitterAds\Fields\JobFields;

class Job extends Analytics
{
    const RESOURCE_COLLECTION = 'stats/jobs/accounts/{account_id}';
    const RESOURCE            = 'stats/jobs/accounts/{account_id}/{id}';
    const ENTITY              = 'JOBS';

    /** Read Only */
    protected $id;
    protected $start_time;
    protected $segmentation_type;
    protected $url;
    protected $id_str;
    protected $entity_ids;
    protected $end_time;
    protected $placement;
    protected $expires_at;
    protected $account_id;
    protected $status;
    protected $granularity;
    protected $entity;
    protected $created_at;
    protected $updated_at;
    protected $metric_groups;

    protected $properties = [];


    public function read($params = [])
    {
        $resource = str_replace(static::RESOURCE_REPLACE, $this->getTwitterAds()->getAccountId(), static::RESOURCE);
        $params[JobFields::JOB_IDS] = $this->id;
        $response = $this->getTwitterAds()->get($resource, $params);
        if (isset($response->getBody()->data[0])) {
            return $this->fromResponse($response->getBody()->data[0]);
        } else {
            return $this;
        }
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
    public function getStartTime()
    {
        return $this->start_time;
    }

    /**
     * @return mixed
     */
    public function getSegmentationType()
    {
        return $this->segmentation_type;
    }

    /**
     * @return mixed
     */
    public function getUrl()
    {
        return $this->url;
    }

    /**
     * @return mixed
     */
    public function getIdStr()
    {
        return $this->id_str;
    }

    /**
     * @return mixed
     */
    public function getEntityIds()
    {
        return $this->entity_ids;
    }

    /**
     * @return mixed
     */
    public function getEndTime()
    {
        return $this->end_time;
    }

    /**
     * @return mixed
     */
    public function getPlacement()
    {
        return $this->placement;
    }

    /**
     * @return mixed
     */
    public function getExpiresAt()
    {
        return $this->expires_at;
    }

    /**
     * @return mixed
     */
    public function getAccountId()
    {
        return $this->account_id;
    }

    /**
     * @return mixed
     */
    public function getStatus()
    {
        return $this->status;
    }

    /**
     * @return mixed
     */
    public function getGranularity()
    {
        return $this->granularity;
    }

    /**
     * @return mixed
     */
    public function getEntity()
    {
        return $this->entity;
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
    public function getMetricGroups()
    {
        return $this->metric_groups;
    }

    /**
     * @return array
     */
    public function getProperties()
    {
        return $this->properties;
    }
}
