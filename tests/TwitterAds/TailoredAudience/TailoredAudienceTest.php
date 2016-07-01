<?php

use Hborras\TwitterAdsSDK\TwitterAds;
use Hborras\TwitterAdsSDK\TwitterAds\TailoredAudience\TailoredAudience;

class TailoredAudienceTest extends \PHPUnit_Framework_TestCase
{
    /** @var TwitterAds */
    protected $twitter;
    private $account;

    /**
     * @expectedException Hborras\TwitterAdsSDK\TwitterAds\TailoredAudience\Exception\InvalidType
     */
    public function testTailoredAudiencesWillThrowAnExceptionWithAnInvalidType()
    {
        $audience = new TailoredAudience(null);
        $audience->setListType('nope');
    }

    public function testTailoredAudiencesCanBeAddedFetchedAndDeletedSuccessfully()
    {
        $audience = new TailoredAudience($this->account);
        $audience->setListType(TailoredAudience::LIST_TYPE_EMAIL);
        $audience->setName('test audience');
        $newAudience = $audience->save();

        $fetched = (new TailoredAudience($this->account))->load($newAudience->getId());
        $this->assertEquals($fetched->getId(), $newAudience->getId());
        $this->assertEquals($fetched->getName(), $newAudience->getName());
        $this->assertEquals($fetched->getListType(), $newAudience->getListType());

        $fetched->delete();
    }

    public function testTailoredAudiencesCanBeFetched()
    {
        $audience = new TailoredAudience($this->account);
        $result = iterator_to_array($audience->all());

        $this->assertGreaterThan(0, $result);
    }

    protected function setUp()
    {
        $this->twitter = new TwitterAds(CONSUMER_KEY, CONSUMER_SECRET, ACCESS_TOKEN, ACCESS_TOKEN_SECRET, false);
        $this->account = $this->getAccount();
    }

    private function getAccount()
    {
        $accounts = $this->twitter->getAccounts();
        $this->assertGreaterThan(0, count($accounts));
        return iterator_to_array($accounts)[0];
    }
}
