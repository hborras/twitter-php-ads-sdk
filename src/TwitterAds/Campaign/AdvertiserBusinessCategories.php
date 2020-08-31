<?php

namespace Hborras\TwitterAdsSDK\TwitterAds\Campaign;

use InvalidArgumentException;
use Hborras\TwitterAdsSDK\TwitterAds;
use Hborras\TwitterAdsSDK\TwitterAds\Cursor;
use Hborras\TwitterAdsSDK\TwitterAdsException;


class AdvertiserBusinessCategories
{
    const RESOURCE_COLLECTION = 'advertiser_business_categories';
    const RESOURCE_REPLACE    = '{account_id}';

    protected $id;
    protected $name;
    protected $iab_categories;

    /** @var  TwitterAds $twitterAds */
    private $twitterAds;

    /**
     * Feature constructor.
     * @param TwitterAds $twitterAds
     */
    public function __construct(TwitterAds $twitterAds)
    {
        $this->twitterAds = static::assureApi($twitterAds);
    }

    /**
     * @param TwitterAds|null $instance
     * @return TwitterAds|null
     */
    protected static function assureApi(TwitterAds $instance = null)
    {
        $instance = $instance ?: TwitterAds::instance();
        if (!$instance) {
            throw new InvalidArgumentException(
                'An Api instance must be provided as argument or ' .
                'set as instance in the \TwitterAds\Api'
            );
        }
        return $instance;
    }

    /**
     * Returns a Cursor instance for a given resource.
     *
     * @param array $params
     *
     * @return Cursor
     * @throws TwitterAds\Errors\BadRequest
     * @throws TwitterAds\Errors\Forbidden
     * @throws TwitterAds\Errors\NotAuthorized
     * @throws TwitterAds\Errors\NotFound
     * @throws TwitterAds\Errors\RateLimit
     * @throws TwitterAds\Errors\ServerError
     * @throws TwitterAds\Errors\ServiceUnavailable
     * @throws TwitterAdsException
     */
    public function all($params = [])
    {
        $resource = str_replace(static::RESOURCE_REPLACE, $this->getTwitterAds()->getAccountId(), static::RESOURCE_COLLECTION);
        $response = $this->getTwitterAds()->get($resource, $params);

        return new Cursor($response->getBody()->data, $this->getTwitterAds(), $response->getBody(), $params);
    }

    /**
     * @return TwitterAds
     */
    public function getTwitterAds()
    {
        return $this->twitterAds;
    }
}
