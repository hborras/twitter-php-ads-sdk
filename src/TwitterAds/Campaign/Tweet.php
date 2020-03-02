<?php

namespace Hborras\TwitterAdsSDK\TwitterAds\Campaign;

use Hborras\TwitterAdsSDK\TwitterAds\Account;
use Hborras\TwitterAdsSDK\TwitterAds\Resource;
use Hborras\TwitterAdsSDK\TwitterAdsException;
use Hborras\TwitterAdsSDK\TwitterAds\Errors\NotFound;
use Hborras\TwitterAdsSDK\TwitterAds\Errors\Forbidden;
use Hborras\TwitterAdsSDK\TwitterAds\Errors\RateLimit;
use Hborras\TwitterAdsSDK\TwitterAds\Errors\BadRequest;
use Hborras\TwitterAdsSDK\TwitterAds\Errors\ServerError;
use Hborras\TwitterAdsSDK\TwitterAds\Fields\TweetFields;
use Hborras\TwitterAdsSDK\TwitterAds\Errors\NotAuthorized;
use Hborras\TwitterAdsSDK\TwitterAds\Errors\ServiceUnavailable;

/**
 * Class Tweet
 * @package Hborras\TwitterAdsSDK\TwitterAds\Campaign
 */
class Tweet
{
    const TWEET_PREVIEW    = 'accounts/{account_id}/tweet/preview';
    const TWEET_ID_PREVIEW = 'accounts/{account_id}/tweet/preview/{id}';
    const TWEET_CREATE     = 'accounts/{account_id}/tweet';

    /**
     * Returns an HTML preview of a tweet, either new or existing.
     *
     * @param Account $account
     * @param array $params
     *
     * @return mixed
     * @throws TwitterAdsException
     * @throws BadRequest
     * @throws Forbidden
     * @throws NotAuthorized
     * @throws NotFound
     * @throws RateLimit
     * @throws ServerError
     * @throws ServiceUnavailable
     */
    public static function preview(Account $account, $params = [])
    {
        if (isset($params[TweetFields::MEDIA_IDS]) && is_array($params[TweetFields::MEDIA_IDS])) {
            $params[TweetFields::MEDIA_IDS] = implode(',', $params[TweetFields::MEDIA_IDS]);
        }

        $resource = isset($params[TweetFields::ID]) ? self::TWEET_ID_PREVIEW : self::TWEET_PREVIEW;
        $resource = str_replace(Resource::RESOURCE_REPLACE, $account->getId(), $resource);
        if (isset($params[TweetFields::ID])) {
            $resource = str_replace(Resource::RESOURCE_ID_REPLACE, $params[TweetFields::ID], $resource);
        }
        $response = $account->getTwitterAds()->get($resource, $params);

        return $response->getBody()->data;
    }

    /**
     * Creates a "Promoted-Only" Tweet using the specialized Ads API end point.
     *
     * @param Account $account
     * @param $text
     * @param array $params
     *
     * @return mixed
     * @throws TwitterAdsException
     * @throws BadRequest
     * @throws Forbidden
     * @throws NotAuthorized
     * @throws NotFound
     * @throws RateLimit
     * @throws ServerError
     * @throws ServiceUnavailable
     */
    public static function create(Account $account, $text, $params = [])
    {
        $params[TweetFields::TEXT] = $text;

        if (isset($params[TweetFields::MEDIA_IDS]) && is_array($params[TweetFields::MEDIA_IDS])) {
            $params[TweetFields::MEDIA_IDS] = implode(',', $params[TweetFields::MEDIA_IDS]);
        }

        $resource = str_replace(Resource::RESOURCE_REPLACE, $account->getId(), self::TWEET_CREATE);
        $response = $account->getTwitterAds()->post($resource, $params);

        return $response->getBody()->data;
    }
}
