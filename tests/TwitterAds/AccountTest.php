<?php
use Hborras\TwitterAdsSDK\TwitterAds;
use Hborras\TwitterAdsSDK\TwitterAds\Account;
use Hborras\TwitterAdsSDK\TwitterAds\Campaign\Campaign;
use Hborras\TwitterAdsSDK\TwitterAds\Campaign\FundingInstrument;
use Hborras\TwitterAdsSDK\TwitterAds\Campaign\LineItem;
use Hborras\TwitterAdsSDK\TwitterAds\Campaign\PromotableUser;
use Hborras\TwitterAdsSDK\TwitterAds\Campaign\TargetingCriteria;
use Hborras\TwitterAdsSDK\TwitterAds\Cursor;
use PHPUnit\Framework\TestCase;

class AccountTest extends TestCase
{
    /** @var TwitterAds */
    protected $api;

    /**
     * @return Account|Cursor
     */
    public function testGetAccounts()
    {
        $this->api = TwitterAds::init(CONSUMER_KEY, CONSUMER_SECRET, ACCESS_TOKEN, ACCESS_TOKEN_SECRET, ACCOUNT_ID, false);
        $cursor = $this->api->getAccounts();
        $this->assertInstanceOf(Cursor::class, $cursor);
        return $cursor;
    }

    /**
     * @depends testGetAccounts
     * @param Cursor $accounts
     * @return Account
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
     */
    public function testGetFeatures(Account $account)
    {
        $features = $account->getFeatures();
        $this->assertGreaterThan(0, count($features));
    }

    /**
     * @depends testGetAccount
     * @param Account $account
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
     */
    public function testGetFundingInstruments(Account $account)
    {
        $cursor = $account->getFundingInstruments();
        $this->assertInstanceOf(Cursor::class, $cursor);
        return $cursor;
    }

    /**
     * @depends testGetFundingInstruments
     * @param Cursor $fundingInstruments
     * @return FundingInstrument
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
     * @return Cursor
     */
    public function testGetCampaigns(Account $account)
    {
        $cursor = $account->getCampaigns();
        $this->assertInstanceOf(Cursor::class, $cursor);
        return $cursor;
    }

    /**
     * @depends testGetCampaigns
     * @param Cursor $campaigns
     * @return Campaign
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
     * @return Cursor
     */
    public function testGetPromotableUsers(Account $account)
    {
        $cursor = $account->getPromotableUsers();
        $this->assertInstanceOf(Cursor::class, $cursor);
        return $cursor;
    }

    /**
     * @depends testGetPromotableUsers
     * @param Cursor $promotableUsers
     * @return PromotableUser
     */
    public function testGetPromotableUser(Cursor $promotableUsers)
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
     * @return Cursor
     */
    public function testGetLineItems(Account $account)
    {
        $cursor = $account->getLineItems();
        $this->assertInstanceOf(Cursor::class, $cursor);
        return $cursor;
    }

    /**
     * @depends testGetLineItems
     * @param Cursor $lineItems
     * @return LineItem
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
     * @return Cursor
     */
    public function testGetTargetingCriterias($lineItem)
    {
        /** @var Cursor $cursor */
        $cursor = $lineItem->getTargetingCriteria();
        $this->assertInstanceOf(Cursor::class, $cursor);
        return $cursor;
    }


    /**
     * @depends testGetTargetingCriterias
     * @param Cursor $targetingCriterias
     * @return TargetingCriteria
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
     * @return Cursor
     */
    public function testGetAppLists(Account $account)
    {
        $cursor = $account->getAppLists();
        $this->assertInstanceOf(Cursor::class, $cursor);
        return $cursor;
    }
}
