<?php
use Hborras\TwitterAdsSDK\TwitterAds;
use Hborras\TwitterAdsSDK\TwitterAds\Account;
use Hborras\TwitterAdsSDK\TwitterAds\Campaign\Campaign;
use Hborras\TwitterAdsSDK\TwitterAds\Campaign\FundingInstrument;
use Hborras\TwitterAdsSDK\TwitterAds\Campaign\LineItem;
use Hborras\TwitterAdsSDK\TwitterAds\Campaign\PromotableUser;
use Hborras\TwitterAdsSDK\TwitterAds\Campaign\TargetingCriteria;
use Hborras\TwitterAdsSDK\TwitterAds\CursorBack;
use Hborras\TwitterAdsSDK\TwitterAdsException;
use PHPUnit\Framework\TestCase;

class AccountTest extends TestCase
{
    /** @var TwitterAds */
    protected $api;

    /**
     * @return Account|CursorBack
     */
    public function testGetAccounts()
    {
        $this->api = TwitterAds::init(CONSUMER_KEY, CONSUMER_SECRET, ACCESS_TOKEN, ACCESS_TOKEN_SECRET, ACCOUNT_ID, false);
        $cursor = $this->api->getAccounts();
        $this->assertInstanceOf(CursorBack::class, $cursor);
        return $cursor;
    }

    /**
     * @depends testGetAccounts
     * @param CursorBack $accounts
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
    public function testGetAccount($accounts)
    {
        /** @var Account $firstAccount */
        $firstAccount = $accounts->current();
        $account = new Account($firstAccount->getId());
        $account->read();
        $this->assertEquals($firstAccount->getId(), $account->getId());
        return $account;
    }

    /**
     * @depends testGetAccount
     * @param Account $account
     * @throws TwitterAdsException
     */
    public function testGetFeatures(Account $account)
    {
        $features = $account->getFeatures();
        $this->assertGreaterThan(0, count($features));
    }

    /**
     * @depends testGetAccount
     * @param Account $account
     * @return CursorBack
     */
    public function testGetFundingInstruments(Account $account)
    {
        $cursor = $account->getFundingInstruments();
        $this->assertInstanceOf(CursorBack::class, $cursor);
        return $cursor;
    }

    /**
     * @depends testGetFundingInstruments
     * @param CursorBack $fundingInstruments
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
    public function testGetFundingInstrument($fundingInstruments)
    {
        /** @var FundingInstrument $firstFundingInstrument */
        $firstFundingInstrument = $fundingInstruments->current();
        $account = new Account($firstFundingInstrument->getTwitterAds()->getAccountId());
        $account->read();
        $fundingInstrument = $account->getFundingInstruments($firstFundingInstrument->getId());
        $this->assertEquals($fundingInstrument->getId(), $firstFundingInstrument->getId());
        return $account;
    }

    /**
     * @depends testGetAccount
     * @param Account $account
     * @return CursorBack
     */
    public function testGetCampaigns(Account $account)
    {
        $cursor = $account->getCampaigns();
        $this->assertInstanceOf(CursorBack::class, $cursor);
        return $cursor;
    }

    /**
     * @depends testGetCampaigns
     * @param CursorBack $campaigns
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
    public function testGetCampaign($campaigns)
    {
        /** @var Campaign $firstCampaign */
        $firstCampaign = $campaigns->current();
        $account = new Account($firstCampaign->getTwitterAds()->getAccountId());
        $account->read();
        $campaign = $account->getCampaigns($firstCampaign->getId());
        $this->assertEquals($campaign->getId(), $firstCampaign->getId());
        return $campaign;
    }

    /**
     * @depends testGetAccount
     * @param Account $account
     * @return CursorBack
     */
    public function testGetPromotableUsers(Account $account)
    {
        $cursor = $account->getPromotableUsers();
        $this->assertInstanceOf(CursorBack::class, $cursor);
        return $cursor;
    }

    /**
     * @depends testGetPromotableUsers
     * @param CursorBack $promotableUsers
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
    public function testGetPromotableUser(CursorBack $promotableUsers)
    {
        /** @var PromotableUser $firstPromotableUser */
        $firstPromotableUser = $promotableUsers->current();
        $account = new Account($firstPromotableUser->getTwitterAds()->getAccountId());
        $account->read();
        $promotableUser = $account->getPromotableUsers($firstPromotableUser->getId());
        $this->assertEquals($promotableUser->getId(), $firstPromotableUser->getId());
        return $promotableUser;
    }

    /**
     * @depends testGetAccount
     * @param Account $account
     * @return CursorBack
     */
    public function testGetLineItems(Account $account)
    {
        $cursor = $account->getLineItems();
        $this->assertInstanceOf(CursorBack::class, $cursor);
        return $cursor;
    }

    /**
     * @depends testGetLineItems
     * @param CursorBack $lineItems
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
    public function testGetLineItem($lineItems)
    {
        /** @var LineItem $firstLineItem */
        $firstLineItem = $lineItems->current();
        $account = new Account($firstLineItem->getTwitterAds()->getAccountId());
        $account->read();
        $lineItem = $account->getLineItems($firstLineItem->getId());
        $this->assertEquals($lineItem->getId(), $firstLineItem->getId());
        return $lineItem;
    }

    /**
     * @depends testGetLineItem
     * @param LineItem $lineItem
     * @return CursorBack
     * @throws TwitterAdsException
     */
    public function testGetTargetingCriterias($lineItem)
    {
        /** @var CursorBack $cursor */
        $cursor = $lineItem->getTargetingCriteria();
        $this->assertInstanceOf(CursorBack::class, $cursor);
        return $cursor;
    }


    /**
     * @depends testGetTargetingCriterias
     * @param CursorBack $targetingCriterias
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
    public function testGetTargetingCriteria($targetingCriterias)
    {
        /** @var TargetingCriteria $firstTargetingCriteria */
        $firstTargetingCriteria = $targetingCriterias->current();
        $targetingCriteria = new TargetingCriteria();
        $targetingCriteria->load($firstTargetingCriteria->getId());
        $this->assertEquals($targetingCriteria->getId(), $firstTargetingCriteria->getId());
        return $targetingCriteria;
    }

    /**
     * @depends testGetAccount
     * @param Account $account
     * @return CursorBack
     */
    public function testGetAppLists(Account $account)
    {
        $cursor = $account->getAppLists();
        $this->assertInstanceOf(CursorBack::class, $cursor);
        return $cursor;
    }
}
