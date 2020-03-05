<?php

namespace Hborras\TwitterAdsSDK\TwitterAds;

use Hborras\TwitterAdsSDK\TwitterAds\Http\Client;
use Hborras\TwitterAdsSDK\TwitterAds\Http\OAuth\OAuth;
use Hborras\TwitterAdsSDK\TwitterAds\Http\OAuth\Signature\HmacSha1;
use Hborras\TwitterAdsSDK\TwitterAds\Http\RequestInterface;
use Hborras\TwitterAdsSDK\TwitterAds\Http\ResponseInterface;
use Hborras\TwitterAdsSDK\TwitterAds\Logger\LoggerInterface;
use Hborras\TwitterAdsSDK\TwitterAds\Logger\NullLogger;

class Api
{
    /**
     * @var string
     */
    const VERSION = ApiConfig::APIVersion;

    /**
     * @var Api
     */
    protected static $instance;

    /**
     * @var SessionInterface
     */
    private $session;

    /**
     * @var LoggerInterface
     */
    protected $logger;

    /**
     * @var Client
     */
    protected $httpClient;

    /**
     * @var string
     */
    protected $defaultVersion;

    /**
     * @param Client $http_client
     * @param SessionInterface $session A TwitterAds API session
     */
    public function __construct(Client $http_client, SessionInterface $session)
    {
        $this->httpClient = $http_client;
        $this->session = $session;
    }

    /**
     * @param string $consumerKey
     * @param string $consumerSecret
     * @param string $oauthToken
     * @param string $oauthTokenSecret
     * @param bool $logCrash
     * @return static
     */
    public static function init(string $consumerKey, string $consumerSecret, string $oauthToken = '', string $oauthTokenSecret = '',
                                $logCrash = true)
    {
        $consumer = new Consumer($consumerKey, $consumerSecret);
        $token = new Token('','');
        if (!empty($oauthToken) && !empty($oauthTokenSecret)) {
            $token = new Token($oauthToken, $oauthTokenSecret);
        }
        $session = new Session($consumer, $token);
        $api = new static(new Client(), $session);
        static::setInstance($api);
        if ($logCrash) {
            //CrashReporter::enable();
        }
        return $api;
    }

    /**
     * @return Api|null
     */
    public static function instance()
    {
        return static::$instance;
    }

    /**
     * @param Api $instance
     */
    public static function setInstance(Api $instance)
    {
        static::$instance = $instance;
    }

    /**
     * @param SessionInterface $session
     * @return Api
     */
    public function getCopyWithSession(SessionInterface $session)
    {
        $api = new self($this->getHttpClient(), $session);
        $api->setDefaultVersion($this->getDefaultVersion());
        $api->setLogger($this->getLogger());
        return $api;
    }

    /**
     * @param string $string
     * @return string
     */
    public static function base64UrlEncode($string)
    {
        $str = strtr(base64_encode($string), '+/', '-_');
        $str = str_replace('=', '', $str);
        return $str;
    }

    /**
     * @param string $path
     * @param string $method
     * @param array $params
     * @return RequestInterface
     */
    public function prepareRequest($path, $method = RequestInterface::METHOD_GET, array $params = [])
    {
        $request = $this->getHttpClient()->createRequest();
        $request->setMethod($method);
        $request->setVersion($this->getDefaultVersion());
        $request->setPath($path);
        $request->setOAuth(new OAuth($this->session->consumer()->key, new HmacSha1(), $this->session->token()->key));

        if ($method === RequestInterface::METHOD_GET) {
            $params_ref = $request->getQueryParams();
        } else {
            $params_ref = $request->getBodyParams();
        }

        if (!empty($params)) {
            $params_ref->enhance($params);
        }

        $params_ref->enhance($this->getSession()->getRequestParameters());

        return $request;
    }

    /**
     * @param RequestInterface $request
     * @return ResponseInterface
     */
    public function executeRequest(RequestInterface $request)
    {
        $this->getLogger()->logRequest('debug', $request);
        $response = $request->execute();
        $this->getLogger()->logResponse('debug', $response);

        return $response;
    }

    /**
     * @return string
     */
    public function getDefaultVersion()
    {
        if ($this->defaultVersion === null) {
            $match = array();
            if (preg_match("/^\d/", static::VERSION, $match)) {
                $this->defaultVersion = $match[0];
            }
        }

        return $this->defaultVersion;
    }

    /**
     * @param string $version
     */
    public function setDefaultVersion($version)
    {
        $this->defaultVersion = $version;
    }

    /**
     * Make graph api calls
     *
     * @param string $path Ads API endpoint
     * @param string $method Ads API request type
     * @param array $params Assoc of request parameters
     * @param array $file_params
     * @return ResponseInterface Graph API responses
     */
    public function call($path, $method = RequestInterface::METHOD_GET, array $params = [], array $file_params = [])
    {
        $request = $this->prepareRequest($path, $method, $params);
        if (!empty($file_params)) {
            foreach ($file_params as $key => $value) {
                $request->getFileParams()->offsetSet($key, $value);
            }
        }
        $request->signRequest($this->session, $params);
        return $this->executeRequest($request);
    }

    /**
     * @return SessionInterface
     */
    public function getSession()
    {
        return $this->session;
    }

    /**
     * @param LoggerInterface $logger
     */
    public function setLogger(LoggerInterface $logger)
    {
        $this->logger = $logger;
    }

    /**
     * @return LoggerInterface
     */
    public function getLogger()
    {
        if ($this->logger === null) {
            $this->logger = new NullLogger();
        }
        return $this->logger;
    }

    /**
     * @return Client
     */
    public function getHttpClient()
    {
        return $this->httpClient;
    }
}
