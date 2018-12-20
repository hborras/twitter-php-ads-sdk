<?php

namespace Hborras\TwitterAdsSDK\TwitterAds\Account;

use Hborras\TwitterAdsSDK\TwitterAds\Analytics;
use Hborras\TwitterAdsSDK\TwitterAds\Analytics\Job;
use Hborras\TwitterAdsSDK\TwitterAds\AuthenticatedUserAccess;
use Hborras\TwitterAdsSDK\TwitterAds\Campaign\AppList;
use Hborras\TwitterAdsSDK\TwitterAds\Campaign\Campaign;
use Hborras\TwitterAdsSDK\TwitterAds\Campaign\Features;
use Hborras\TwitterAdsSDK\TwitterAds\Campaign\FundingInstrument;
use Hborras\TwitterAdsSDK\TwitterAds\Campaign\LineItem;
use Hborras\TwitterAdsSDK\TwitterAds\Campaign\PromotableUser;
use Hborras\TwitterAdsSDK\TwitterAds\Creative\Video;
use Hborras\TwitterAdsSDK\TwitterAds\Errors\DeleteOnlyInSandBoxException;
use Hborras\TwitterAdsSDK\TwitterAds\Fields\AnalyticsFields;
use Hborras\TwitterAdsSDK\TwitterAds\TailoredAudience\TailoredAudience;
use Hborras\TwitterAdsSDK\TwitterAds\Fields\AccountFields;

class Account extends Analytics
{
    const RESOURCE_REPLACE          = '{account_id}';
    const RESOURCE_COLLECTION       = 'accounts';
    const RESOURCE                  = 'accounts/{account_id}';
    const FEATURES                  = 'accounts/{account_id}/features';
    const APP_LISTS                 = 'accounts/{account_id}/app_lists';
    const SCOPED_TIMELINE           = 'accounts/{account_id}/scoped_timeline';
    const AUTHENTICATED_USER_ACCESS = 'accounts/{account_id}/authenticated_user_access';

    const ENTITY = 'ACCOUNT';

    /** @var string */
    protected $id;
    protected $salt;
    protected $name;
    protected $timezone;
    protected $timezone_switch_at;
    protected $created_at;
    protected $updated_at;
    protected $deleted;
    protected $approval_status;
    protected $business_id;
    protected $business_name;
    protected $industry_type;

    /**
     * @param $metricGroups
     * @param array $params
     * @param bool $async
     * @return mixed
     */
    public function stats($metricGroups, $params = [], $async = false)
    {
        $params[AnalyticsFields::ENTITY] = AnalyticsFields::ACCOUNT;
        return parent::stats($metricGroups, $params, $async);
    }

    /**
     * @return Account
     */
    public function read()
    {
        $resource = str_replace(static::RESOURCE_REPLACE, $this->id, static::RESOURCE);
        $response = $this->getTwitterAds()->get($resource, []);

        return $this->fromResponse($response->getBody()->data);
    }

    /**
     * @return Feature[]
     */
    public function features()
    {
        $resource = str_replace(self::RESOURCE_REPLACE, $this->getId(), self::FEATURES);
        $response = $this->getTwitterAds()->get($resource);

        return Features::fromResponse($response->getBody()->data);
    }

    /**
     * @param $response
     * @return Account
     * @throws \Exception
     */
    public function fromResponse($response)
    {
        $timezone = $response->timezone;
        foreach (get_object_vars($response) as $key => $value) {
            if (($key == 'created_at' || $key == 'updated_at' || $key == 'start_time' || $key == 'end_time' || $key == 'timezone_switch_at') && !is_null($value)) {
                $this->$key = $this->toDateTimeImmutable($value, $timezone);
            } else {
                $this->$key = $value;
            }
        }

        return $this;
    }

    /**
     * @param string $id
     *
     * @param array $params
     * @return FundingInstrument|Cursor
     */
    public function getFundingInstruments($id = '', $params = [])
    {
        $fundingInstrumentClass = new FundingInstrument();

        return $fundingInstrumentClass->loadResource($id, $params);
    }

    /**
     *
     * @param string $id
     *
     * @param array $params
     * @return PromotableUser|Cursor
     */
    public function getPromotableUsers($id = '', $params = [])
    {
        $promotableUserClass = new PromotableUser();

        return $promotableUserClass->loadResource($id, $params);
    }

    /**
     * @param string $id
     *
     * @param array $params
     * @return Campaign|Cursor
     */
    public function getCampaigns($id = '', $params = [])
    {
        $campaignClass = new Campaign();

        return $campaignClass->loadResource($id, $params);
    }

    /**
     * @param string $id
     *
     * @param array $params
     * @return LineItem|Cursor
     */
    public function getLineItems($id = '', $params = [])
    {
        $lineItemsClass = new LineItem();

        return $lineItemsClass->loadResource($id, $params);
    }

    /**
     * @param string $id
     *
     * @param array $params
     * @return AppList|Cursor
     */
    public function getAppLists($id = '', $params = [])
    {
        $appListsClass = new AppList();

        return $appListsClass->loadResource($id, $params);
    }

    /**
     * @param array $params
     * @return Cursor|Resource
     */
    public function getJobs($params = [])
    {
        $jobsClass = new Job();

        return $jobsClass->loadResource('', $params);
    }


    /**
     * @param array $params
     * @return Cursor|Resource
     */
    public function getTailoredAudiences($params = [])
    {
        $tailoredAudienceClass = new TailoredAudience();

        return $tailoredAudienceClass->loadResource('', $params);
    }

    /**
     * @param string $id
     * @param array $params
     * @return Cursor|Video
     */
    public function getVideos($id = '', $params = [])
    {
        $videoClass = new Video();

        return $videoClass->loadResource($id, $params);
    }

    /**
     * @param $ids
     * @param $params
     * @return
     * @throws Errors\ServerError
     */
    public function getScopedTimeline($ids, $params)
    {
        $this->validateLoaded();

        if (is_array($ids)) {
            $ids = implode(',', $ids);
        }
        $params[] = [AccountFields::USER_IDS => $ids];

        $resource = str_replace(self::RESOURCE_REPLACE, $this->getId(), self::SCOPED_TIMELINE);
        $response = $this->getTwitterAds()->get($resource, $params);

        return $response->getBody()->data;
    }

    /**
     * @return Account
     * @throws DeleteOnlyInSandBoxException
     */
    public function delete()
    {
        if(!$this->getTwitterAds()->isSandBox()){
            throw new DeleteOnlyInSandBoxException();
        }

        $resource = str_replace(static::RESOURCE_REPLACE, $this->getTwitterAds()->getAccountId(), static::RESOURCE);
        $response = $this->getTwitterAds()->delete($resource);
        return $this->fromResponse($response->getBody()->data);
    }

    /**
     * @return AuthenticatedUserAccess
     */
    public function authenticatedUserAccess()
    {
        $resource = str_replace(static::RESOURCE_REPLACE, $this->getTwitterAds()->getAccountId(),
            static::AUTHENTICATED_USER_ACCESS);
        $response = $this->getTwitterAds()->get($resource);
        return AuthenticatedUserAccess::fromResponse($response->getBody()->data);
    }


    /**
     * @return string
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @return string
     */
    public function getSalt()
    {
        return $this->salt;
    }

    /**
     * @return mixed
     */
    public function getTimezone()
    {
        return $this->timezone;
    }

    /**
     * @return \DateTimeImmutable
     */
    public function getTimezoneSwitchAt()
    {
        return $this->timezone_switch_at;
    }

    /**
     * @return \DateTimeImmutable
     */
    public function getCreatedAt()
    {
        return $this->created_at;
    }

    /**
     * @return \DateTimeImmutable
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
        return filter_var($this->deleted, FILTER_VALIDATE_BOOLEAN);
    }

    /**
     * @return mixed
     */
    public function getApprovalStatus()
    {
        return $this->approval_status;
    }

    /**
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * @return mixed
     */
    public function getBusinessId()
    {
        return $this->business_id;
    }

    /**
     * @return mixed
     */
    public function getBusinessName()
    {
        return $this->business_name;
    }

    /**
     * @return mixed
     */
    public function getIndustryType()
    {
        return $this->industry_type;
    }

    /**
     * @param mixed $industry_type
     */
    public function setIndustryType($industry_type)
    {
        $this->industry_type = $industry_type;
    }
}
