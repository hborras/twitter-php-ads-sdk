<?php
/**
 * WARNING: Running these tests will post and delete through the actual Twitter account.
 */
namespace Hborras\TwitterAdsSDK\Test;

use DateTimeInterface;
use Hborras\TwitterAdsSDK\TwitterAds;
use Hborras\TwitterAdsSDK\TwitterAds\Account;
use PHPUnit\Framework\TestCase;

class TwitterAdsTest extends TestCase
{
    /** @var TwitterAds */
    protected $api;

    protected function setUp()
    {
        $this->api = TwitterAds::init(CONSUMER_KEY, CONSUMER_SECRET, ACCESS_TOKEN, ACCESS_TOKEN_SECRET, null, false);
    }

    public function testBuildClient()
    {
        $this->assertObjectHasAttribute('consumer', $this->api);
        $this->assertObjectHasAttribute('token', $this->api);
    }

    public function testSetOauthToken()
    {
        $this->api->setOauthToken(ACCESS_TOKEN, ACCESS_TOKEN_SECRET);
        $this->assertObjectHasAttribute('consumer', $this->api);
        $this->assertObjectHasAttribute('token', $this->api);
        $this->api->get('accounts');
        $this->assertEquals(200, $this->api->getLastHttpCode());
    }

    public function testOauth2Token()
    {
        $result = $this->api->oauth2('oauth2/token', array('grant_type' => 'client_credentials'));
        $this->assertEquals(200, $this->api->getLastHttpCode());
        $this->assertObjectHasAttribute('token_type', $result);
        $this->assertObjectHasAttribute('access_token', $result);
        $this->assertEquals('bearer', $result->token_type);
        return $result;
    }

    public function testOauthRequestToken()
    {
        $result = $this->api->oauth('oauth/request_token', array('oauth_callback' => OAUTH_CALLBACK));
        $this->assertEquals(200, $this->api->getLastHttpCode());
        $this->assertArrayHasKey('oauth_token', $result);
        $this->assertArrayHasKey('oauth_token_secret', $result);
        $this->assertArrayHasKey('oauth_callback_confirmed', $result);
        $this->assertEquals('true', $result['oauth_callback_confirmed']);
        return $result;
    }

    /**
     * @expectedException \Hborras\TwitterAdsSDK\TwitterAdsException
     * @expectedExceptionMessage Could not authenticate you
     */
    public function testOauthRequestTokenException()
    {
        $twitter = new TwitterAds('CONSUMER_KEY', 'CONSUMER_SECRET');
        $result = $twitter->oauth('oauth/request_token', array('oauth_callback' => OAUTH_CALLBACK));
        return $result;
    }

    /**
     * @expectedException \Hborras\TwitterAdsSDK\TwitterAdsException
     * @expectedExceptionMessage Error processing your OAuth request: Invalid oauth_verifier parameter
     * @depends testOauthRequestToken
     * @param array $requestToken
     * @throws \Hborras\TwitterAdsSDK\TwitterAdsException
     */
    public function testOauthAccessTokenTokenException(array $requestToken)
    {
        // Can't test this without a browser logging into Twitter so check for the correct error instead.
        $twitter = new TwitterAds(
            CONSUMER_KEY,
            CONSUMER_SECRET,
            $requestToken['oauth_token'],
            $requestToken['oauth_token_secret']
        );
        $twitter->oauth('oauth/access_token', array('oauth_verifier' => 'fake_oauth_verifier'));
    }

    public function testUrl()
    {
        $url = $this->api->url('oauth/authorize', array('foo' => 'bar', 'baz' => 'qux'));
        $this->assertEquals('https://api.twitter.com/oauth/authorize?foo=bar&baz=qux', $url);
    }
}
