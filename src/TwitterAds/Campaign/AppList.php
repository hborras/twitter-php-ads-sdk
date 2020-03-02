<?php

namespace Hborras\TwitterAdsSDK\TwitterAds\Campaign;

use Hborras\TwitterAdsSDK\TwitterAds\Resource;
use Hborras\TwitterAdsSDK\TwitterAdsException;
use Hborras\TwitterAdsSDK\TwitterAds\Errors\NotFound;
use Hborras\TwitterAdsSDK\TwitterAds\Errors\Forbidden;
use Hborras\TwitterAdsSDK\TwitterAds\Errors\RateLimit;
use Hborras\TwitterAdsSDK\TwitterAds\Errors\BadRequest;
use Hborras\TwitterAdsSDK\TwitterAds\Errors\ServerError;
use Hborras\TwitterAdsSDK\TwitterAds\Errors\NotAuthorized;
use Hborras\TwitterAdsSDK\TwitterAds\Fields\AppListFields;
use Hborras\TwitterAdsSDK\TwitterAds\Errors\ServiceUnavailable;

/**
 * Class AppList
 * @package Hborras\TwitterAdsSDK\TwitterAds\Campaign
 */
class AppList extends Resource
{
    const RESOURCE_COLLECTION = 'accounts/{account_id}/app_lists';
    const RESOURCE            = 'accounts/{account_id}/app_lists/{id}';

    /** Read Only */
    protected $id;
    protected $name;
    protected $apps;

    protected $properties = [
    ];

    /**
     * @param $name
     * @param array $ids
     * @return AppList
     * @throws TwitterAdsException
     * @throws BadRequest
     * @throws Forbidden
     * @throws NotAuthorized
     * @throws NotFound
     * @throws RateLimit
     * @throws ServerError
     * @throws ServiceUnavailable
     */
    public function create($name, $ids = [])
    {
        if (is_array($ids)) {
            $ids = implode(',', $ids);
        }

        $resource = str_replace(static::RESOURCE_REPLACE, $this->getTwitterAds()->getAccountId(), static::RESOURCE_COLLECTION);
        $params = $this->toParams();
        $params[AppListFields::APP_STORE_IDENTIFIERS] = $ids;
        $params[AppListFields::NAME] = $name;
        $response = $this->getTwitterAds()->get($resource, $params);

        return $this->fromResponse($response->getBody()->data);
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
    public function getName()
    {
        return $this->name;
    }

    /**
     * @return mixed
     */
    public function getApps()
    {
        return $this->apps;
    }

}
