<?php
/**
 * WARNING: Running these tests will post and delete through the actual Twitter account.
 */
namespace Hborras\TwitterAds\Test;

use Hborras\TwitterAds\TwitterAds;

class TwitterAdsTest extends \PHPUnit_Framework_TestCase
{
    /** @var TwitterAds */
    protected $twitter;

    protected function setUp()
    {
        $this->twitter = new TwitterAds(CONSUMER_KEY, CONSUMER_SECRET, ACCESS_TOKEN, ACCESS_TOKEN_SECRET);
    }

    public function testBuildClient()
    {
        $this->assertObjectHasAttribute('consumer', $this->twitter);
        $this->assertObjectHasAttribute('token', $this->twitter);
    }

    public function testSetOauthToken()
    {
        $twitter = new TwitterAds(CONSUMER_KEY, CONSUMER_SECRET);
        $twitter->setOauthToken(ACCESS_TOKEN, ACCESS_TOKEN_SECRET);
        $this->assertObjectHasAttribute('consumer', $twitter);
        $this->assertObjectHasAttribute('token', $twitter);
        $twitter->get('accounts');
        $this->assertEquals(200, $twitter->getLastHttpCode());
    }

    public function testOauth2Token()
    {
        $twitter = new TwitterAds(CONSUMER_KEY, CONSUMER_SECRET);
        $result = $twitter->oauth2('oauth2/token', array('grant_type' => 'client_credentials'));
        $this->assertEquals(200, $twitter->getLastHttpCode());
        $this->assertObjectHasAttribute('token_type', $result);
        $this->assertObjectHasAttribute('access_token', $result);
        $this->assertEquals('bearer', $result->token_type);
        return $result;
    }

    // This causes issues for parallel run tests.
    // /**
    //  * @depends testBearerToken
    //  */
    // public function testOauth2TokenInvalidate($accessToken)
    // {
    //     $twitter = new TwitterOAuth(CONSUMER_KEY, CONSUMER_SECRET);
    //     // HACK: access_token is already urlencoded but gets urlencoded again breaking the invalidate request.
    //     $result = $twitter->oauth2(
    //         'oauth2/invalidate_token',
    //         array('access_token' => urldecode($accessToken->access_token))
    //     );
    //     $this->assertEquals(200, $twitter->getLastHttpCode());
    //     $this->assertObjectHasAttribute('access_token', $result);
    //     return $result;
    // }

    public function testOauthRequestToken()
    {
        $twitter = new TwitterAds(CONSUMER_KEY, CONSUMER_SECRET);
        $result = $twitter->oauth('oauth/request_token', array('oauth_callback' => OAUTH_CALLBACK));
        $this->assertEquals(200, $twitter->getLastHttpCode());
        $this->assertArrayHasKey('oauth_token', $result);
        $this->assertArrayHasKey('oauth_token_secret', $result);
        $this->assertArrayHasKey('oauth_callback_confirmed', $result);
        $this->assertEquals('true', $result['oauth_callback_confirmed']);
        return $result;
    }

    /**
     * @expectedException \Hborras\TwitterAds\TwitterAdsException
     * @expectedExceptionMessage Could not authenticate you
     */
    public function testOauthRequestTokenException()
    {
        $twitter = new TwitterAds('CONSUMER_KEY', 'CONSUMER_SECRET');
        $result = $twitter->oauth('oauth/request_token', array('oauth_callback' => OAUTH_CALLBACK));
        return $result;
    }

    /**
     * @expectedException \Hborras\TwitterAds\TwitterAdsException
     * @expectedExceptionMessage Invalid oauth_verifier parameter
     * @depends testOauthRequestToken
     * @param array $requestToken
     * @throws \Hborras\TwitterAds\TwitterAdsException
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
        $twitter->oauth("oauth/access_token", array("oauth_verifier" => "fake_oauth_verifier"));
    }

    public function testUrl()
    {
        $url = $this->twitter->url('oauth/authorize', array('foo' => 'bar', 'baz' => 'qux'));
        $this->assertEquals('https://api.twitter.com/oauth/authorize?foo=bar&baz=qux', $url);
    }

    // BUG: testing is too unreliable for now
    // public function testSetProxy()
    // {
    //     $this->twitter->setProxy(array(
    //         'CURLOPT_PROXY' => PROXY,
    //         'CURLOPT_PROXYUSERPWD' => PROXYUSERPWD,
    //         'CURLOPT_PROXYPORT' => PROXYPORT,
    //     ));
    //     $this->twitter->setTimeouts(60, 60);
    //     $result = $this->twitter->get('account/verify_credentials');
    //     $this->assertEquals(200, $this->twitter->getLastHttpCode());
    //     $this->assertObjectHasAttribute('id', $result);
    // }

}
