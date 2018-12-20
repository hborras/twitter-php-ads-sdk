<?php

namespace Hborras\TwitterAdsSDK\TwitterAds;


use Hborras\TwitterAdsSDK\TwitterAds\Errors\AuthenticatedUserAccess\NotAvailablePermission;
use Hborras\TwitterAdsSDK\TwitterAds\Errors\AuthenticatedUserAccess\UndefinedPermissions;
use Hborras\TwitterAdsSDK\TwitterAds\Errors\AuthenticatedUserAccess\UndefinedUserId;

class AuthenticatedUserAccess
{
    const PERMISSIONS = [
        'ACCOUNT_ADMIN',
        'AD_MANAGER',
        'CAMPAIGN_ANALYST',
        'ANALYST',
        'TWEET_COMPOSER'
    ];

    /** @var string */
    private $userId;

    /** @var array  */
    private $permissions;

    public function __construct(string $userId, array $permissions)
    {
        $this->userId = $userId;
        $this->permissions = $permissions;
    }

    /**
     * @param $response
     * @return AuthenticatedUserAccess
     * @throws UndefinedPermissions
     * @throws UndefinedUserId
     */
    public static function fromResponse($response)
    {
        if(!isset($response->user_id)){
            throw new UndefinedUserId();
        }

        if(!isset($response->permissions)){
            throw new UndefinedPermissions();
        }

        foreach ($response->permissions as $permission) {
            if(!in_array($permission, self::PERMISSIONS)){
                throw new NotAvailablePermission();
            }
        }

        $userId = $response->user_id;
        $permissions = $response->permissions;

        return new AuthenticatedUserAccess($userId, $permissions);
    }

    /**
     * @return string
     */
    public function getUserId(): string
    {
        return $this->userId;
    }

    /**
     * @return array
     */
    public function getPermissions(): array
    {
        return $this->permissions;
    }
}