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

    public function testTailoredAudiencesCanBeAddedSuccessfully()
    {
        $this->markTestSkipped('waiting for write access to twitter ads api');
        $audience = new TailoredAudience($this->account);
        $audience->setListType(TailoredAudience::LIST_TYPE_EMAIL);
        $audience->save();
    }

    public function testTailoredAudiencesCanBeFetched()
    {
        $audience = new TailoredAudience($this->account);
        $result = iterator_to_array($audience->all());

        $this->assertGreaterThan(0, $result);
    }

    public function testTailoredAudiencesCanBeRemoved()
    {
        $this->markTestSkipped('waiting for write access to twitter ads api');
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
