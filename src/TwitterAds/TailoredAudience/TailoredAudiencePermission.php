<?php

namespace Hborras\TwitterAdsSDK\TwitterAds\TailoredAudience;

use Hborras\TwitterAdsSDK\TwitterAds\Cursor;
use Hborras\TwitterAdsSDK\TwitterAds\Resource;
use Hborras\TwitterAdsSDK\TwitterAdsException;
use Hborras\TwitterAdsSDK\TwitterAds\Errors\NotFound;
use Hborras\TwitterAdsSDK\TwitterAds\Errors\Forbidden;
use Hborras\TwitterAdsSDK\TwitterAds\Errors\RateLimit;
use Hborras\TwitterAdsSDK\TwitterAds\Errors\BadRequest;
use Hborras\TwitterAdsSDK\TwitterAds\Errors\ServerError;
use Hborras\TwitterAdsSDK\TwitterAds\Errors\NotAuthorized;
use Hborras\TwitterAdsSDK\TwitterAds\Errors\ServiceUnavailable;

/**
 * Class TailoredAudiencePermission
 * @package Hborras\TwitterAdsSDK\TwitterAds\TailoredAudience
 */
final class TailoredAudiencePermission extends Resource
{
    const RESOURCE_COLLECTION                   = 'accounts/{account_id}/custom_audiences/{tailored_audience_id/permissions}';
    const RESOURCE                              = 'accounts/{account_id}/custom_audiences/{tailored_audience_id/permissions}/{id}';
    const RESOURCE_TAILORED_AUDIENCE_ID_REPLACE = '{tailored_audience_id}';


    /** Writable */
    protected $tailored_audience_id;
    protected $granted_account_id;
    protected $permission_level;

    protected $properties = [
        'tailored_audience_id',
        'granted_account_id',
        'permission_level'
    ];

    /** Read Only */
    protected $deleted;
    protected $id;
    protected $updated_at;
    protected $created_at;

    /**
     * Returns a Cursor instance for the given tailored audience permission resource.
     *
     * @param array $tailoredAudienceId
     * @param array $params
     * @return Cursor
     * @throws TwitterAdsException
     * @throws BadRequest
     * @throws Forbidden
     * @throws NotAuthorized
     * @throws NotFound
     * @throws RateLimit
     * @throws ServerError
     * @throws ServiceUnavailable
     */
    public function all($tailoredAudienceId, $params = [])
    {
        $resource = str_replace(static::RESOURCE_REPLACE, $this->getTwitterAds()->getAccountId(), static::RESOURCE);
        $resource = str_replace(self::RESOURCE_TAILORED_AUDIENCE_ID_REPLACE, $tailoredAudienceId, $resource);

        $response = $this->getTwitterAds()->get($resource, $params);

        return new Cursor($this, $this->getTwitterAds(), $response->getBody(), $params);
    }

    /**
     * Saves or updates the current tailored audience permission.
     *
     * @return $this
     * @throws TwitterAdsException
     * @throws BadRequest
     * @throws Forbidden
     * @throws NotAuthorized
     * @throws NotFound
     * @throws RateLimit
     * @throws ServerError
     * @throws ServiceUnavailable
     */
    public function save()
    {
        if (!$this->getId()) {
            $resource = str_replace(static::RESOURCE_REPLACE, $this->getTwitterAds()->getAccountId(), static::RESOURCE);
            $resource = str_replace(self::RESOURCE_TAILORED_AUDIENCE_ID_REPLACE, $this->getTailoredAudienceId(), $resource);
            $response = $this->getTwitterAds()->post($resource, []);
        } else {
            $resource = str_replace(static::RESOURCE_REPLACE, $this->getTwitterAds()->getAccountId(), static::RESOURCE);
            $resource = str_replace(self::RESOURCE_TAILORED_AUDIENCE_ID_REPLACE, $this->getTailoredAudienceId(), $resource);
            $resource = str_replace(static::RESOURCE_ID_REPLACE, $this->getId(), $resource);
            $response = $this->getTwitterAds()->put($resource, []);
        }

        return $this->fromResponse($response->getBody()->data);
    }

    /**
     * Saves or updates the current tailored audience permission.
     *
     * @return $this
     * @throws TwitterAdsException
     * @throws BadRequest
     * @throws Forbidden
     * @throws NotAuthorized
     * @throws NotFound
     * @throws RateLimit
     * @throws ServerError
     * @throws ServiceUnavailable
     */
    public function delete()
    {
        $resource = str_replace(static::RESOURCE_REPLACE, $this->getTwitterAds()->getAccountId(), static::RESOURCE);
        $resource = str_replace(self::RESOURCE_TAILORED_AUDIENCE_ID_REPLACE, $this->getTailoredAudienceId(), $resource);
        $resource = str_replace(static::RESOURCE_ID_REPLACE, $this->getId(), $resource);
        $response = $this->getTwitterAds()->delete($resource, []);

        return $this->fromResponse($response->getBody()->data);
    }

    /**
     * @return mixed
     */
    public function getTailoredAudienceId()
    {
        return $this->tailored_audience_id;
    }

    /**
     * @param mixed $tailored_audience_id
     */
    public function setTailoredAudienceId($tailored_audience_id)
    {
        $this->tailored_audience_id = $tailored_audience_id;
    }

    /**
     * @return mixed
     */
    public function getGrantedAccountId()
    {
        return $this->granted_account_id;
    }

    /**
     * @param mixed $granted_account_id
     */
    public function setGrantedAccountId($granted_account_id)
    {
        $this->granted_account_id = $granted_account_id;
    }

    /**
     * @return mixed
     */
    public function getPermissionLevel()
    {
        return $this->permission_level;
    }

    /**
     * @param mixed $permission_level
     */
    public function setPermissionLevel($permission_level)
    {
        $this->permission_level = $permission_level;
    }

    /**
     * @return mixed
     */
    public function getDeleted()
    {
        return $this->deleted;
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
    public function getUpdatedAt()
    {
        return $this->updated_at;
    }

    /**
     * @return mixed
     */
    public function getCreatedAt()
    {
        return $this->created_at;
    }
}
