<?php

use Hborras\TwitterAdsSDK\TwitterAds;
use Hborras\TwitterAdsSDK\TwitterAds\TailoredAudience\TailoredAudience;
use Hborras\TwitterAdsSDK\TwitterAds\TailoredAudience\TailoredAudienceChanges;
use Hborras\TwitterAdsSDK\TwitterAds\Campaign\Campaign;
use Hborras\TwitterAdsSDK\TwitterAds\Cursor;

class TailoredAudienceChangesTest extends \PHPUnit_Framework_TestCase
{
    /** @var TwitterAds */
    protected $twitter;

    /**
     * @expectedException Hborras\TwitterAdsSDK\TwitterAds\TailoredAudience\Exception\InvalidOperation
     */
    public function testTailoredAudienceChangesWillThrowAnExceptionWithAnInvalidOperation()
    {
        $audience = new TailoredAudienceChanges(null);
        $audience->setOperation('nope');
    }

    public function testTailoredAudienceChangesCanBeFetchedAndUpdated()
    {
        $this->markTestSkipped('waiting for write access to twitter ads api');
        $accounts = $this->twitter->getAccounts();
        $this->assertGreaterThan(0, count($accounts));

        $account = iterator_to_array($accounts)[0];
        $audience = new TailoredAudience($account);
        $audience->setListType(TailoredAudience::LIST_TYPE_EMAIL);
        $audience->save();
    }

    protected function setUp()
    {
        $this->twitter = new TwitterAds(CONSUMER_KEY, CONSUMER_SECRET, ACCESS_TOKEN, ACCESS_TOKEN_SECRET, false);
    }
}
