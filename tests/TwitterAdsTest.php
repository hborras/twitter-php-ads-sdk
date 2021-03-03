<?php
/**
 * WARNING: Running these tests will post and delete through the actual Twitter account.
 */
namespace Hborras\TwitterAdsSDK\Test;

use Exception;
use Hborras\TwitterAdsSDK\TwitterAds;
use Hborras\TwitterAdsSDK\TwitterAdsException;
use PHPUnit\Framework\TestCase;

class TwitterAdsTest extends TestCase
{
    /** @var TwitterAds */
    protected $api;

    protected function setUp(): void
    {
        $this->api = TwitterAds::init(CONSUMER_KEY, CONSUMER_SECRET, ACCESS_TOKEN, ACCESS_TOKEN_SECRET, '', false);
    }

    public function testBuildClient(): void
    {
        self::assertObjectHasAttribute('consumer', $this->api);
        self::assertObjectHasAttribute('token', $this->api);
    }

    public function testSetOauthToken(): void
    {
        $this->api->setOauthToken(ACCESS_TOKEN, ACCESS_TOKEN_SECRET);
        self::assertObjectHasAttribute('consumer', $this->api);
        self::assertObjectHasAttribute('token', $this->api);
        $this->api->get('accounts');
        self::assertEquals(200, $this->api->getLastHttpCode());
    }

    public function testOauth2Token()
    {
        $result = $this->api->oauth2('oauth2/token', array('grant_type' => 'client_credentials'));
        self::assertEquals(200, $this->api->getLastHttpCode());
        self::assertObjectHasAttribute('token_type', $result);
        self::assertObjectHasAttribute('access_token', $result);
        self::assertEquals('bearer', $result->token_type);
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
        $result = $this->api->oauth('oauth/request_token', array('oauth_callback' => OAUTH_CALLBACK));
        self::assertEquals(200, $this->api->getLastHttpCode());
        self::assertArrayHasKey('oauth_token', $result);
        self::assertArrayHasKey('oauth_token_secret', $result);
        self::assertArrayHasKey('oauth_callback_confirmed', $result);
        self::assertEquals('true', $result['oauth_callback_confirmed']);
        return $result;
    }

    public function testOauthRequestTokenException(): array
    {
        $this->expectExceptionMessage("Could not authenticate you");
        $this->expectException(TwitterAdsException::class);
        $twitter = new TwitterAds('CONSUMER_KEY', 'CONSUMER_SECRET');
        $result = $twitter->oauth('oauth/request_token', array('oauth_callback' => OAUTH_CALLBACK));
        return $result;
    }

    /**
     *
     *
     * @depends testOauthRequestToken
     * @param array $requestToken
     * @throws Exception
     */
    public function testOauthAccessTokenTokenException(array $requestToken): void
    {
        $this->expectExceptionMessage("Error processing your OAuth request: Invalid oauth_verifier parameter");
        $this->expectException(TwitterAdsException::class);
        // Can't test this without a browser logging into Twitter so check for the correct error instead.
        $twitter = new TwitterAds(
            CONSUMER_KEY,
            CONSUMER_SECRET,
            $requestToken['oauth_token'],
            $requestToken['oauth_token_secret']
        );
        $twitter->oauth('oauth/access_token', array('oauth_verifier' => 'fake_oauth_verifier'));
    }

    public function testUrl(): void
    {
        $url = $this->api->url('oauth/authorize', array('foo' => 'bar', 'baz' => 'qux'));
        self::assertEquals('https://api.twitter.com/oauth/authorize?foo=bar&baz=qux', $url);
    }
}
