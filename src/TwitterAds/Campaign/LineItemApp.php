<?php
/**
 * Created by PhpStorm.
 * User: hborras
 * Date: 11/01/18
 * Time: 21:28
 */

namespace Hborras\TwitterAdsSDK\TwitterAds\Campaign;


use Hborras\TwitterAdsSDK\TwitterAds\Fields\LineItemAppFields;
use Hborras\TwitterAdsSDK\TwitterAds\Resource;

class LineItemApp extends Resource
{
    const RESOURCE_COLLECTION = 'accounts/{account_id}/line_item_apps';
    const RESOURCE            = 'accounts/{account_id}/line_item_apps/{id}';
    const ENTITY              = 'LINE_ITEM_APP';

    /** Read Only */
    protected $id;
    protected $created_at;
    protected $updated_at;
    protected $deleted;

    protected $properties = [
        LineItemAppFields::LINE_ITEM_ID,
        LineItemAppFields::APP_STORE_IDENTIFIER,
        LineItemAppFields::OS_TYPE
    ];

    protected $line_item_id;
    protected $app_store_identifier;
    protected $os_type;

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
     * @return mixed
     */
    public function getLineItemId()
    {
        return $this->line_item_id;
    }

    /**
     * @return mixed
     */
    public function getAppStoreIdentifier()
    {
        return $this->app_store_identifier;
    }

    /**
     * @return mixed
     */
    public function getOsType()
    {
        return $this->os_type;
    }

    /**
     * @param mixed $line_item_id
     */
    public function setLineItemId($line_item_id)
    {
        $this->line_item_id = $line_item_id;
    }

    /**
     * @param mixed $app_store_identifier
     */
    public function setAppStoreIdentifier($app_store_identifier)
    {
        $this->app_store_identifier = $app_store_identifier;
    }

    /**
     * @param mixed $os_type
     */
    public function setOsType($os_type)
    {
        $this->os_type = $os_type;
    }
}