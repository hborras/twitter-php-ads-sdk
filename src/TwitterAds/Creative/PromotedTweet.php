<?php
/**
 * Created by PhpStorm.
 * User: hborras
 * Date: 17/04/16
 * Time: 22:41.
 */
namespace Hborras\TwitterAdsSDK\TwitterAds\Creative;

use Hborras\TwitterAdsSDK\TwitterAds\Analytics;

class PromotedTweet extends Analytics
{
    const RESOURCE_COLLECTION = 'accounts/{account_id}/promoted_tweets';
    const RESOURCE = 'accounts/{account_id}/promoted_tweets/{id}';
    const RESOURCE_STATS = 'stats/accounts/{account_id}/promoted_tweets/{id}';

    const ENTITY = 'PROMOTED_TWEET';

    /** Read Only */
    protected $id;
    protected $approval_status;
    protected $created_at;
    protected $updated_at;
    protected $deleted;

    protected $properties = [
        'line_item_id',
        'tweet_id',
        'paused',
    ];

    /** Writable */
    protected $line_item_id;
    protected $tweet_id;
    protected $paused;

    /**
     * Saves or updates the current object instance depending on the
     * presence of `object->getId()`.
     */
    public function save()
    {
        $params = $this->toParams();
        if (isset($params['tweet_id'])) {
            $params['tweet_ids'] = $params['tweet_id'];
            unset($params['tweet_id']);
        }

        if ($this->getId()) {
            $resource = str_replace(static::RESOURCE_REPLACE, $this->getAccount()->getId(), static::RESOURCE);
            $resource = str_replace(static::RESOURCE_ID_REPLACE, $this->getId(), $resource);
            $response = $this->getAccount()->getTwitterAds()->put($resource, $params);

            return $this->fromResponse($response->getBody()->data);
        } else {
            $resource = str_replace(static::RESOURCE_REPLACE, $this->getAccount()->getId(), static::RESOURCE_COLLECTION);
            $response = $this->getAccount()->getTwitterAds()->post($resource, $params);

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
    public function getLineItemId()
    {
        return $this->line_item_id;
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
     * @param mixed $line_item_id
     */
    public function setLineItemId($line_item_id)
    {
        $this->line_item_id = $line_item_id;
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
