<?php
/**
 * Created by PhpStorm.
 * User: hborras
 * Date: 27/03/16
 * Time: 13:16.
 */
namespace Hborras\TwitterAdsSDK\TwitterAds;

use Hborras\TwitterAdsSDK\TwitterAds;
use Hborras\TwitterAdsSDK\TwitterAds\Campaign\AppList;
use Hborras\TwitterAdsSDK\TwitterAds\Campaign\Campaign;
use Hborras\TwitterAdsSDK\TwitterAds\Campaign\FundingInstrument;
use Hborras\TwitterAdsSDK\TwitterAds\Campaign\LineItem;
use Hborras\TwitterAdsSDK\TwitterAds\Campaign\PromotableUser;
use Hborras\TwitterAdsSDK\TwitterAds\Creative\Video;
use Hborras\TwitterAdsSDK\TwitterAdsException;

class Account extends Resource
{
    const RESOURCE_REPLACE          = '{account_id}';
    const RESOURCE_COLLECTION       = 'accounts';
    const RESOURCE                  = 'accounts/{account_id}';
    const FEATURES                  = 'accounts/{account_id}/features';
    const APP_LISTS                 = 'accounts/{account_id}/app_lists';
    const SCOPED_TIMELINE           = 'accounts/{account_id}/scoped_timeline';
    const AUTHENTICATED_USER_ACCESS = 'accounts/{account_id}/authenticated_user_access';

    private $twitterAds;

    protected $id;
    protected $salt;
    protected $name;
    protected $timezone;
    protected $timezone_switch_at;
    protected $created_at;
    protected $updated_at;
    protected $deleted;
    protected $approval_status;

    public function __construct(TwitterAds $twitterAds)
    {
        parent::__construct();
        $this->twitterAds = $twitterAds;
    }

    /**
     * @param array|null $params
     *
     * @return Cursor
     */
    public function all($params = [])
    {
        $resource = self::RESOURCE_COLLECTION;
        $request = $this->twitterAds->get($resource, $params);

        return new Cursor($this, $this, $request, $params);
    }

    /**
     * Returns an object instance for a given resource.
     *
     * @param $id
     * @param array $params
     *
     * @return $this
     */
    public function load($id, $params = [])
    {
        $resource = str_replace(self::RESOURCE_REPLACE, $id, self::RESOURCE);
        $request = $this->twitterAds->get($resource, $params);

        return $this->fromResponse($request->data);
    }

    /**
     * Reloads all attributes for the current object instance from the API.
     *
     * @param array $params
     *
     * @return $this
     */
    public function reload($params = [])
    {
        if ($this->getId() == '') {
            return $this;
        }
        $params[] = ['with_deleted' => true];

        $resource = str_replace(self::RESOURCE_REPLACE, $this->getId(), self::RESOURCE);
        $request = $this->twitterAds->get($resource, $params);
        $this->fromResponse($request->data);

        return $this;
    }

    /**
     * Returns a collection of features available to the current account.
     *
     * @return mixed
     *
     * @throws TwitterAdsException
     */
    public function getFeatures()
    {
        $this->validateLoaded();

        $resource = str_replace(self::RESOURCE_REPLACE, $this->getId(), self::FEATURES);
        $response = $this->twitterAds->get($resource);

        return $response->data;
    }

    /**
     * Returns a collection of promotable users available to the current account.
     *
     * @param string $id
     *
     * @param array $params
     * @return PromotableUser|Cursor
     */
    public function getPromotableUsers($id = '', $params = [])
    {
        $promotableUserClass = new PromotableUser();

        return $promotableUserClass->loadResource($this, $id, $params);
    }

    /**
     * Returns a collection of funding instruments available to the current account.
     *
     * @param string $id
     *
     * @param array $params
     * @return FundingInstrument|Cursor
     */
    public function getFundingInstruments($id = '', $params = [])
    {
        $fundingInstrumentClass = new FundingInstrument();

        return $fundingInstrumentClass->loadResource($this, $id, $params);
    }

    /**
     * Returns a collection of campaigns available to the current account.
     *
     * @param string $id
     *
     * @param array $params
     * @return Campaign|Cursor
     */
    public function getCampaigns($id = '', $params = [])
    {
        $campaignClass = new Campaign();

        return $campaignClass->loadResource($this, $id, $params);
    }

    /**
     * Returns a collection of line items available to the current account.
     *
     * @param string $id
     *
     * @param array $params
     * @return LineItem|Cursor
     */
    public function getLineItems($id = '', $params = [])
    {
        $lineItemsClass = new LineItem();

        return $lineItemsClass->loadResource($this, $id, $params);
    }

    /**
     * Returns a collection of app lists available to the current account.
     *
     * @param string $id
     *
     * @param array $params
     * @return AppList|Cursor
     */
    public function getAppLists($id = '', $params = [])
    {
        $appListsClass = new AppList();

        return $appListsClass->loadResource($this, $id, $params);
    }


    public function getTailoredAudiences($id = '',  $params = [])
    {
        // TODO: Next Release
    }

    /**
     * Returns a collection of videos available to the current account.
     *
     * @param string $id
     * @param array $params
     * @return Cursor|Video
     */
    public function getVideos($id = '', $params = [])
    {
        $videoClass = new Video();

        return $videoClass->loadResource($this, $id, $params);
    }

    /**
     * Returns the most recent promotable Tweets created by one or more specified Twitter users.
     *
     * @param $ids
     * @param $params
     */
    public function getScopedTimeline($ids, $params)
    {
        $this->validateLoaded();

        if (is_array($ids)) {
            $ids = implode(',', $ids);
        }
        $params[] = ['user_ids' => $ids];

        $resource = str_replace(self::RESOURCE_REPLACE, $this->getId(), self::SCOPED_TIMELINE);
        $response = $this->twitterAds->get($resource, $params);

        return $response->data;
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
     * @return mixed
     */
    public function getTimezoneSwitchAt()
    {
        return $this->timezone_switch_at;
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
     * @return mixed
     */
    public function getApprovalStatus()
    {
        return $this->approval_status;
    }

    /**
     * @return TwitterAds
     */
    public function getTwitterAds()
    {
        return $this->twitterAds;
    }

    /**
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }
}
