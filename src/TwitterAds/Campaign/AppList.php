<?php
/**
 * Created by PhpStorm.
 * User: hborras
 * Date: 3/04/16
 * Time: 11:59.
 */
namespace Hborras\TwitterAdsSDK\TwitterAds\Campaign;

use Hborras\TwitterAdsSDK\TwitterAds\Fields\AppListFields;
use Hborras\TwitterAdsSDK\TwitterAds\Resource;

class AppList extends Resource
{
    const RESOURCE_COLLECTION = 'accounts/{account_id}/app_lists';
    const RESOURCE = 'accounts/{account_id}/app_lists/{id}';

    /** Read Only */
    protected $id;
    protected $name;
    protected $apps;

    protected $properties = [
    ];

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

    /**
     * @return array
     */
    public function getProperties()
    {
        return $this->properties;
    }
}
