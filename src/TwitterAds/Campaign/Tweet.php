<?php
/**
 * Created by PhpStorm.
 * User: hborras
 * Date: 3/04/16
 * Time: 11:59.
 */
namespace Hborras\TwitterAdsSDK\TwitterAds\Campaign;

use Hborras\TwitterAdsSDK\TwitterAds\Account;
use Hborras\TwitterAdsSDK\TwitterAds\Resource;

class Tweet
{
    const TWEET_PREVIEW = 'accounts/{account_id}/tweet/preview';
    const TWEET_ID_PREVIEW = 'accounts/{account_id}/tweet/preview/{id}';
    const TWEET_CREATE = 'accounts/{account_id}/tweet';

    /**
     * Returns an HTML preview of a tweet, either new or existing.
     *
     * @param Account $account
     * @param array   $params
     *
     * @return mixed
     */
    public static function preview(Account $account, $params = [])
    {
        if (isset($params['media_ids']) && is_array($params['media_ids'])) {
            $params['media_ids'] = implode(',', $params['media_ids']);
        }

        $resource = isset($params['id']) ? self::TWEET_ID_PREVIEW : self::TWEET_PREVIEW;
        $resource = str_replace(Resource::RESOURCE_REPLACE, $account->getId(), $resource);
        if (isset($params['id'])) {
            $resource = str_replace(Resource::RESOURCE_ID_REPLACE, $params['id'], $resource);
        }
        $response = $account->getTwitterAds()->get($resource, $params);

        return $response->data;
    }

    /**
     * Creates a "Promoted-Only" Tweet using the specialized Ads API end point.
     *
     * @param Account $account
     * @param $status
     * @param array $params
     *
     * @return mixed
     */
    public static function create(Account $account, $status, $params = [])
    {
        $params['status'] = $status;

        if (isset($params['media_ids']) && is_array($params['media_ids'])) {
            $params['media_ids'] = implode(',', $params['media_ids']);
        }

        $resource = str_replace(Resource::RESOURCE_REPLACE, $account->getId(), self::TWEET_CREATE);
        $result = $account->getTwitterAds()->post($resource, $params);

        return $result->data;
    }
}
