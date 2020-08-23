<?php

namespace Hborras\TwitterAdsSDK\TwitterAds\Campaign;

use Hborras\TwitterAdsSDK\TwitterAds\Analytics;
use Hborras\TwitterAdsSDK\TwitterAds\Fields\AnalyticsFields;
use Hborras\TwitterAdsSDK\TwitterAds\Errors\BadRequest;
use Hborras\TwitterAdsSDK\TwitterAds\Fields\ScheduledTweetFields;

class ScheduledTweet extends Analytics
{
    const RESOURCE_COLLECTION = 'accounts/{account_id}/scheduled_tweets';
    const RESOURCE            = 'accounts/{account_id}/scheduled_tweets/{id}';
    const RESOURCE_STATS      = 'stats/accounts/{account_id}/scheduled_tweets/{id}';

    const ENTITY = 'SCHEDULED_TWEET';

    /** Read Only */
    protected $id;
    protected $completed_at;
    protected $user_id;
    protected $scheduled_status;

    protected $properties = [
        ScheduledTweetFields::SCHEDULED_AT,
        ScheduledTweetFields::AS_USER_ID,
        ScheduledTweetFields::TEXT,
        ScheduledTweetFields::CARD_URI,
        ScheduledTweetFields::MEDIA_KEYS,
        ScheduledTweetFields::NULLCAST,
    ];

    /** Writable */
    protected $scheduled_at;
    protected $as_user_id;
    protected $text;
    protected $card_uri;
    protected $media_keys;
    protected $nullcast;

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
        if ($this->getId()) {
            $resource = str_replace(static::RESOURCE_REPLACE, $this->getTwitterAds()->getAccountId(), static::RESOURCE);
            $resource = str_replace(static::RESOURCE_ID_REPLACE, $this->getId(), $resource);
            $response = $this->getTwitterAds()->put($resource, $params);

            return $this->fromResponse($response->getBody()->data);
        }
        $resource = str_replace(static::RESOURCE_REPLACE, $this->getTwitterAds()->getAccountId(), static::RESOURCE_COLLECTION);
        $response = $this->getTwitterAds()->post($resource, $params);

        return $this->fromResponse($response->getBody()->data[0]);
    }

    /**
     * @return mixed
     */
    public function getId()
    {
        return $this->id;
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
    public function completed_at()
    {
        return $this->completed_at;
    }

    /**
     * @return mixed
     */
    public function user_id()
    {
        return $this->user_id;
    }

    /**
     * @return mixed
     */
    public function scheduled_status()
    {
        return $this->scheduled_status;
    }

    /**
     * @return array
     */
    public function properties(): array
    {
        return $this->properties;
    }

    /**
     * @return mixed
     */
    public function scheduled_at()
    {
        return $this->scheduled_at;
    }

    /**
     * @return mixed
     */
    public function as_user_id()
    {
        return $this->as_user_id;
    }

    /**
     * @return mixed
     */
    public function text()
    {
        return $this->text;
    }

    /**
     * @return mixed
     */
    public function card_uri()
    {
        return $this->card_uri;
    }

    /**
     * @return mixed
     */
    public function media_keys()
    {
        return $this->media_keys;
    }

    /**
     * @return mixed
     */
    public function nullcast()
    {
        return $this->nullcast;
    }

    /**
     * @param mixed $scheduled_at
     */
    public function setScheduledAt($scheduled_at): void
    {
        $this->scheduled_at = $scheduled_at;
    }

    /**
     * @param mixed $as_user_id
     */
    public function setAsUserId($as_user_id): void
    {
        $this->as_user_id = $as_user_id;
    }

    /**
     * @param mixed $text
     */
    public function setText($text): void
    {
        $this->text = $text;
    }

    /**
     * @param mixed $card_uri
     */
    public function setCardUri($card_uri): void
    {
        $this->card_uri = $card_uri;
    }

    /**
     * @param mixed $media_keys
     */
    public function setMediaKeys($media_keys): void
    {
        $this->media_keys = $media_keys;
    }

    /**
     * @param mixed $nullcast
     */
    public function setNullcast($nullcast): void
    {
        $this->nullcast = $nullcast;
    }
}