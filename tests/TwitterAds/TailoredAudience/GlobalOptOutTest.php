<?php

use Hborras\TwitterAdsSDK\TwitterAds;
use Hborras\TwitterAdsSDK\TwitterAds\Account;
use Hborras\TwitterAdsSDK\TwitterAds\TailoredAudience\TailoredAudience;
use Hborras\TwitterAdsSDK\TwitterAds\TailoredAudience\GlobalOptOut;
use PHPUnit\Framework\TestCase;

class GlobalOptOutTest extends TestCase
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
        $this->markTestSkipped("Not prepared");
        $twitterAds = $this->getMockBuilder(TwitterAds::class)
            ->disableOriginalConstructor()
            ->getMock();

        $account = new Account($twitterAds);
        $url = sprintf('accounts/%s/tailored_audiences/global_opt_out', $account->getId());

        $optPut = new GlobalOptOut($account);
        $optPut->setListType(TailoredAudience::LIST_TYPE_EMAIL);

        $data = (object)['data' => (object)[
            'input_file_path' => 'test',
            'list_type' => TailoredAudience::LIST_TYPE_EMAIL,
        ]];

        $twitterAds->expects($this->once())
            ->method('put')
            ->with($url, $optPut->toParams())
            ->willReturn($data);

        $optPut->save();
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
