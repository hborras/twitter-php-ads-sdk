<?php
use Hborras\TwitterAdsSDK\TwitterAds;
use Hborras\TwitterAdsSDK\TwitterAds\Account;
use Hborras\TwitterAdsSDK\TwitterAds\Campaign\Campaign;
use Hborras\TwitterAdsSDK\TwitterAds\Campaign\FundingInstrument;
use Hborras\TwitterAdsSDK\TwitterAds\Campaign\LineItem;
use Hborras\TwitterAdsSDK\TwitterAds\Campaign\PromotableUser;
use Hborras\TwitterAdsSDK\TwitterAds\Campaign\TargetingCriteria;
use Hborras\TwitterAdsSDK\TwitterAds\Cursor;

/**
 * User: Hector Borras Aleixandre
 * Date: 2/04/16
 * Time: 13:22
 */
class AccountTest extends \PHPUnit_Framework_TestCase
{
    /** @var TwitterAds */
    protected $twitter;

    /**
     * Set up the client
     */
    protected function setUp()
    {
        $this->twitter = new TwitterAds(CONSUMER_KEY, CONSUMER_SECRET, ACCESS_TOKEN, ACCESS_TOKEN_SECRET, false);
    }

    /**
     * @return Account|Cursor
     */
    public function testGetAccounts()
    {
        $cursor = $this->twitter->getAccounts();
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
        $firstAccount = $accounts->next();
        $account = $this->twitter->getAccounts($firstAccount->getId());
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
        $firstFundingInstrument = $fundingInstruments->next();
        $account = $firstFundingInstrument->getAccount();
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
        $firstCampaign = $campaigns->next();
        $account = $firstCampaign->getAccount();
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
        $firstPromotableUser = $promotableUsers->next();
        $account = $firstPromotableUser->getAccount();
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
        $firstLineItem = $lineItems->next();
        $account = $firstLineItem->getAccount();
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
        $firstTargetingCriteria = $targetingCriterias->next();
        $targetingCriteria = new TargetingCriteria();
        $targetingCriteria->setAccount($firstTargetingCriteria->getAccount());
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