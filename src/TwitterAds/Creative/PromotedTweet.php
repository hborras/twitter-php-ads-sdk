<?php
/**
 * Created by PhpStorm.
 * User: hborras
 * Date: 17/04/16
 * Time: 22:41.
 */
namespace Hborras\TwitterAdsSDK\TwitterAds\Creative;

use Hborras\TwitterAdsSDK\TwitterAds\Analytics;
use Hborras\TwitterAdsSDK\TwitterAds\Fields\AnalyticsFields;
use Hborras\TwitterAdsSDK\TwitterAds\Fields\PromotedTweetFields;

class PromotedTweet extends Analytics
{
    const RESOURCE_COLLECTION = 'accounts/{account_id}/promoted_tweets';
    const RESOURCE            = 'accounts/{account_id}/promoted_tweets/{id}';
    const RESOURCE_STATS      = 'stats/accounts/{account_id}/promoted_tweets/{id}';

    const ENTITY = 'PROMOTED_TWEET';

    /** Read Only */
    protected $id;
    protected $approval_status;
    protected $created_at;
    protected $updated_at;
    protected $deleted;

    protected $properties = [
        PromotedTweetFields::TWEET_ID,
        PromotedTweetFields::PAUSED,
    ];

    /** Writable */
    protected $tweet_id;
    protected $paused;

    /**
     * @param $metricGroups
     * @param array $params
     * @param bool $async
     * @return mixed
     */
    public function stats($metricGroups, $params = [], $async = false)
    {
        $params[AnalyticsFields::ENTITY] = AnalyticsFields::PROMOTED_TWEET;
        return parent::stats($metricGroups, $params, $async);
    }

    /**
     * Saves or updates the current object instance depending on the
     * presence of `object->getId()`.
     */
    public function save()
    {
        $params = $this->toParams();
        if (isset($params[PromotedTweetFields::TWEET_ID])) {
            $params[PromotedTweetFields::TWEET_IDS] = $params[PromotedTweetFields::TWEET_ID];
            unset($params[PromotedTweetFields::TWEET_ID]);
        }

        if ($this->getId()) {
            $resource = str_replace(static::RESOURCE_REPLACE, $this->getTwitterAds()->getAccountId(), static::RESOURCE);
            $resource = str_replace(static::RESOURCE_ID_REPLACE, $this->getId(), $resource);
            $response = $this->getTwitterAds()->put($resource, $params);

            return $this->fromResponse($response->getBody()->data);
        } else {
            $resource = str_replace(static::RESOURCE_REPLACE, $this->getTwitterAds()->getAccountId(), static::RESOURCE_COLLECTION);
            $response = $this->getTwitterAds()->post($resource, $params);

            return $this->fromResponse($response->getBody()->data[0]);
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
    public function getApprovalStatus()
    {
        return $this->approval_status;
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
     * @return mixed
     */
    public function getTweetId()
    {
        return $this->tweet_id;
    }

    /**
     * @return mixed
     */
    public function getPaused()
    {
        return $this->paused;
    }

    /**
     * @param array $properties
     */
    public function setProperties($properties)
    {
        $this->properties = $properties;
    }

    /**
     * @param mixed $tweet_id
     */
    public function setTweetId($tweet_id)
    {
        $this->tweet_id = $tweet_id;
    }

    /**
     * @param mixed $paused
     */
    public function setPaused($paused)
    {
        $this->paused = $paused;
    }
}
