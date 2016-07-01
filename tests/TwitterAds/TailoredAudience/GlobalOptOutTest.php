<?php

use Hborras\TwitterAdsSDK\TwitterAds;
use Hborras\TwitterAdsSDK\TwitterAds\Account;
use Hborras\TwitterAdsSDK\TwitterAds\TailoredAudience\TailoredAudience;
use Hborras\TwitterAdsSDK\TwitterAds\TailoredAudience\GlobalOptOut;

class GlobalOptOutTest extends \PHPUnit_Framework_TestCase
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

    public function testHackedUrlWillGenerateTheExpectedRoute()
    {
        $twitterAds = $this->getMockBuilder(TwitterAds::class)
            ->disableOriginalConstructor()
            ->getMock();

        $account = new Account($twitterAds);
        $url = sprintf('accounts/%s/tailored_audiences/global_opt_out', $account->getId());

        $optout = new GlobalOptOut($account);
        $optout->setListType(TailoredAudience::LIST_TYPE_EMAIL);

        $data = (object)['data' => (object) [
            'input_file_path' => 'test',
            'list type' => TailoredAudience::LIST_TYPE_EMAIL,
        ]];
        $twitterAds->expects($this->once())
            ->method('put')
            ->with($url, $optout->toParams())
            ->willReturn($data);

        $optout->save();
    }

    public function testTailoredAudienceGlobalOptOutCanBeUpdatedSuccessfully()
    {
        $this->markTestSkipped('waiting for write access to twitter ads api');
        $audience = new GlobalOptOut(null);
        $audience->setListType(TailoredAudience::LIST_TYPE_EMAIL);
        $audience->save();
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
