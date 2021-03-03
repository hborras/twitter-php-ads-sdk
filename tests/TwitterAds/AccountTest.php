<?php
use Hborras\TwitterAdsSDK\TwitterAds;
use Hborras\TwitterAdsSDK\TwitterAds\Account;
use Hborras\TwitterAdsSDK\TwitterAds\Campaign\Campaign;
use Hborras\TwitterAdsSDK\TwitterAds\Campaign\FundingInstrument;
use Hborras\TwitterAdsSDK\TwitterAds\Campaign\LineItem;
use Hborras\TwitterAdsSDK\TwitterAds\Campaign\PromotableUser;
use Hborras\TwitterAdsSDK\TwitterAds\Campaign\TargetingCriteria;
use Hborras\TwitterAdsSDK\TwitterAds\Cursor;
use Hborras\TwitterAdsSDK\TwitterAdsException;
use PHPUnit\Framework\TestCase;

class AccountTest extends TestCase
{
    /** @var TwitterAds */
    protected $api;

    /**
     * Set up the client
     */
    protected function setUp()
    {
        $this->api = TwitterAds::init(CONSUMER_KEY, CONSUMER_SECRET, ACCESS_TOKEN, ACCESS_TOKEN_SECRET, ACCOUNT_ID, false);
    }

    /**
     * @return Account|Cursor
     * @throws TwitterAdsException
     * @throws TwitterAds\Errors\BadRequest
     * @throws TwitterAds\Errors\Forbidden
     * @throws TwitterAds\Errors\NotAuthorized
     * @throws TwitterAds\Errors\NotFound
     * @throws TwitterAds\Errors\RateLimit
     * @throws TwitterAds\Errors\ServerError
     * @throws TwitterAds\Errors\ServiceUnavailable
     */
    public function testGetAccounts()
    {
        $cursor = $this->api->getAccounts();
        self::assertInstanceOf(Cursor::class, $cursor);
        return $cursor;
    }

    /**
     * @depends testGetAccounts
     * @param Cursor $accounts
     * @return Account
     * @throws TwitterAdsException
     * @throws TwitterAds\Errors\BadRequest
     * @throws TwitterAds\Errors\Forbidden
     * @throws TwitterAds\Errors\NotAuthorized
     * @throws TwitterAds\Errors\NotFound
     * @throws TwitterAds\Errors\RateLimit
     * @throws TwitterAds\Errors\ServerError
     * @throws TwitterAds\Errors\ServiceUnavailable
     */
    public function testGetAccount(Cursor $accounts): Account
    {
        /** @var Account $firstAccount */
        $firstAccount = $accounts->current();
        $account = new Account(ACCOUNT_ID);
        $account->read();
        self::assertEquals(ACCOUNT_ID, $account->getId());
        return $account;
    }

    /**
     * @depends testGetAccount
     * @param Account $account
     * @throws TwitterAdsException
     */
    public function testGetFeatures(Account $account): void
    {
        $features = $account->getFeatures();
        self::assertGreaterThan(0, count($features));
    }

    /**
     * @depends testGetAccount
     * @param Account $account
     * @throws TwitterAds\Errors\BadRequest
     * @throws TwitterAds\Errors\Forbidden
     * @throws TwitterAds\Errors\NotAuthorized
     * @throws TwitterAds\Errors\NotFound
     * @throws TwitterAds\Errors\RateLimit
     * @throws TwitterAds\Errors\ServerError
     * @throws TwitterAds\Errors\ServiceUnavailable
     * @throws TwitterAdsException
     */
    public function testScopedTimeline(Account $account)
    {
        $scopedTimeline = $account->getScopedTimeline(null, null);
        $this->assertGreaterThan(0, count($scopedTimeline));
    }

    /**
     * @depends testGetAccount
     * @param Account $account
     * @return Cursor
     * @throws TwitterAdsException
     * @throws TwitterAds\Errors\BadRequest
     * @throws TwitterAds\Errors\Forbidden
     * @throws TwitterAds\Errors\NotAuthorized
     * @throws TwitterAds\Errors\NotFound
     * @throws TwitterAds\Errors\RateLimit
     * @throws TwitterAds\Errors\ServerError
     * @throws TwitterAds\Errors\ServiceUnavailable
     */
    public function testGetFundingInstruments(Account $account): Cursor
    {
        $cursor = $account->getFundingInstruments();
        self::assertInstanceOf(Cursor::class, $cursor);
        return $cursor;
    }

    /**
     * @depends testGetFundingInstruments
     * @param Cursor $fundingInstruments
     * @return Account
     * @throws TwitterAdsException
     * @throws TwitterAds\Errors\BadRequest
     * @throws TwitterAds\Errors\Forbidden
     * @throws TwitterAds\Errors\NotAuthorized
     * @throws TwitterAds\Errors\NotFound
     * @throws TwitterAds\Errors\RateLimit
     * @throws TwitterAds\Errors\ServerError
     * @throws TwitterAds\Errors\ServiceUnavailable
     */
    public function testGetFundingInstrument(Cursor $fundingInstruments): Account
    {
        /** @var FundingInstrument $firstFundingInstrument */
        $firstFundingInstrument = $fundingInstruments->current();
        $account = new Account($firstFundingInstrument->getTwitterAds()->getAccountId());
        $account->read();
        $fundingInstrument = $account->getFundingInstruments($firstFundingInstrument->getId());
        self::assertEquals($fundingInstrument->getId(), $firstFundingInstrument->getId());
        return $account;
    }

    /**
     * @depends testGetAccount
     * @param Account $account
     * @return Cursor
     * @throws TwitterAdsException
     * @throws TwitterAds\Errors\BadRequest
     * @throws TwitterAds\Errors\Forbidden
     * @throws TwitterAds\Errors\NotAuthorized
     * @throws TwitterAds\Errors\NotFound
     * @throws TwitterAds\Errors\RateLimit
     * @throws TwitterAds\Errors\ServerError
     * @throws TwitterAds\Errors\ServiceUnavailable
     */
    public function testGetCampaigns(Account $account): Cursor
    {
        $cursor = $account->getCampaigns();
        self::assertInstanceOf(Cursor::class, $cursor);
        return $cursor;
    }

    /**
     * @depends testGetCampaigns
     * @param Cursor $campaigns
     * @return Campaign
     * @throws TwitterAdsException
     * @throws TwitterAds\Errors\BadRequest
     * @throws TwitterAds\Errors\Forbidden
     * @throws TwitterAds\Errors\NotAuthorized
     * @throws TwitterAds\Errors\NotFound
     * @throws TwitterAds\Errors\RateLimit
     * @throws TwitterAds\Errors\ServerError
     * @throws TwitterAds\Errors\ServiceUnavailable
     */
    public function testGetCampaign(Cursor $campaigns): Campaign
    {
        /** @var Campaign $firstCampaign */
        $firstCampaign = $campaigns->current();
        $account = new Account($firstCampaign->getTwitterAds()->getAccountId());
        $account->read();
        $campaign = $account->getCampaigns($firstCampaign->getId());
        self::assertEquals($campaign->getId(), $firstCampaign->getId());
        return $campaign;
    }

    /**
     * @depends testGetAccount
     * @param Account $account
     * @return Cursor
     * @throws TwitterAdsException
     * @throws TwitterAds\Errors\BadRequest
     * @throws TwitterAds\Errors\Forbidden
     * @throws TwitterAds\Errors\NotAuthorized
     * @throws TwitterAds\Errors\NotFound
     * @throws TwitterAds\Errors\RateLimit
     * @throws TwitterAds\Errors\ServerError
     * @throws TwitterAds\Errors\ServiceUnavailable
     */
    public function testGetPromotableUsers(Account $account): Cursor
    {
        $cursor = $account->getPromotableUsers();
        self::assertInstanceOf(Cursor::class, $cursor);
        return $cursor;
    }

    /**
     * @depends testGetPromotableUsers
     * @param Cursor $promotableUsers
     * @return PromotableUser
     * @throws TwitterAdsException
     * @throws TwitterAds\Errors\BadRequest
     * @throws TwitterAds\Errors\Forbidden
     * @throws TwitterAds\Errors\NotAuthorized
     * @throws TwitterAds\Errors\NotFound
     * @throws TwitterAds\Errors\RateLimit
     * @throws TwitterAds\Errors\ServerError
     * @throws TwitterAds\Errors\ServiceUnavailable
     */
    public function testGetPromotableUser(Cursor $promotableUsers): PromotableUser
    {
        /** @var PromotableUser $firstPromotableUser */
        $firstPromotableUser = $promotableUsers->current();
        $account = new Account($firstPromotableUser->getTwitterAds()->getAccountId());
        $account->read();
        $promotableUser = $account->getPromotableUsers($firstPromotableUser->getId());
        self::assertEquals($promotableUser->getId(), $firstPromotableUser->getId());
        return $promotableUser;
    }

    /**
     * @depends testGetAccount
     * @param Account $account
     * @return Cursor
     * @throws TwitterAdsException
     * @throws TwitterAds\Errors\BadRequest
     * @throws TwitterAds\Errors\Forbidden
     * @throws TwitterAds\Errors\NotAuthorized
     * @throws TwitterAds\Errors\NotFound
     * @throws TwitterAds\Errors\RateLimit
     * @throws TwitterAds\Errors\ServerError
     * @throws TwitterAds\Errors\ServiceUnavailable
     */
    public function testGetLineItems(Account $account): Cursor
    {
        $cursor = $account->getLineItems();
        self::assertInstanceOf(Cursor::class, $cursor);
        return $cursor;
    }

    /**
     * @depends testGetLineItems
     * @param Cursor $lineItems
     * @return LineItem
     * @throws TwitterAdsException
     * @throws TwitterAds\Errors\BadRequest
     * @throws TwitterAds\Errors\Forbidden
     * @throws TwitterAds\Errors\NotAuthorized
     * @throws TwitterAds\Errors\NotFound
     * @throws TwitterAds\Errors\RateLimit
     * @throws TwitterAds\Errors\ServerError
     * @throws TwitterAds\Errors\ServiceUnavailable
     */
    public function testGetLineItem(Cursor $lineItems): LineItem
    {
        /** @var LineItem $firstLineItem */
        $firstLineItem = $lineItems->current();
        $account = new Account($firstLineItem->getTwitterAds()->getAccountId());
        $account->read();
        $lineItem = $account->getLineItems($firstLineItem->getId());
        self::assertEquals($lineItem->getId(), $firstLineItem->getId());
        return $lineItem;
    }

    /**
     * @depends testGetLineItem
     * @param LineItem $lineItem
     * @return Cursor
     * @throws TwitterAdsException
     */
    public function testGetTargetingCriterias(LineItem $lineItem): Cursor
    {
        /** @var Cursor $cursor */
        $cursor = $lineItem->getTargetingCriteria();
        self::assertInstanceOf(Cursor::class, $cursor);
        return $cursor;
    }


    /**
     * @depends testGetTargetingCriterias
     * @param Cursor $targetingCriterias
     * @return TargetingCriteria
     * @throws TwitterAds\Errors\BadRequest
     * @throws TwitterAds\Errors\Forbidden
     * @throws TwitterAds\Errors\NotAuthorized
     * @throws TwitterAds\Errors\NotFound
     * @throws TwitterAds\Errors\RateLimit
     * @throws TwitterAds\Errors\ServerError
     * @throws TwitterAds\Errors\ServiceUnavailable
     * @throws TwitterAdsException
     */
    public function testGetTargetingCriteria(Cursor $targetingCriterias): TargetingCriteria
    {
        /** @var TargetingCriteria $firstTargetingCriteria */
        $firstTargetingCriteria = $targetingCriterias->current();
        $targetingCriteria = new TargetingCriteria();
        $targetingCriteria->load($firstTargetingCriteria->getId());
        self::assertEquals($targetingCriteria->getId(), $firstTargetingCriteria->getId());
        return $targetingCriteria;
    }

    /**
     * @depends testGetAccount
     * @param Account $account
     * @return Cursor
     * @throws TwitterAdsException
     * @throws TwitterAds\Errors\BadRequest
     * @throws TwitterAds\Errors\Forbidden
     * @throws TwitterAds\Errors\NotAuthorized
     * @throws TwitterAds\Errors\NotFound
     * @throws TwitterAds\Errors\RateLimit
     * @throws TwitterAds\Errors\ServerError
     * @throws TwitterAds\Errors\ServiceUnavailable
     */
    public function testGetAppLists(Account $account): Cursor
    {
        $cursor = $account->getAppLists();
        self::assertInstanceOf(Cursor::class, $cursor);
        return $cursor;
    }
}
