<?php

namespace Hborras\TwitterAdsSDK\TwitterAds\Campaign;

use Hborras\TwitterAdsSDK\TwitterAds\Resource;

/**
 * Created by PhpStorm.
 * User: hborras
 * Date: 3/04/16
 * Time: 10:43.
 */
class PromotableUser extends Resource
{
    const RESOURCE_COLLECTION = 'accounts/{account_id}/promotable_users';
    const RESOURCE = 'accounts/{account_id}/promotable_users/{id}';

    protected $id;
    protected $promotable_user_type;
    protected $user_id;
    protected $created_at;
    protected $updated_at;
    protected $deleted;

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
    public function getPromotableUserType()
    {
        return $this->promotable_user_type;
    }

    /**
     * @return mixed
     */
    public function getUserId()
    {
        return $this->user_id;
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
}
