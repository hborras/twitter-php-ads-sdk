<?php
/**
 * A Twitter supported and maintained Ads API SDK for PHP.
 *
 * @license MIT
 */
namespace Hborras\TwitterAdsSDK;

use Exception;
use Hborras\TwitterAdsSDK\TwitterAds\Account;
use Hborras\TwitterAdsSDK;
use Hborras\TwitterAdsSDK\TwitterAds\Cursor;
use Hborras\TwitterAdsSDK\TwitterAds\Errors\BadRequest;
use Hborras\TwitterAdsSDK\TwitterAds\Errors\Forbidden;
use Hborras\TwitterAdsSDK\TwitterAds\Errors\NotAuthorized;
use Hborras\TwitterAdsSDK\TwitterAds\Errors\NotFound;
use Hborras\TwitterAdsSDK\TwitterAds\Errors\RateLimit;
use Hborras\TwitterAdsSDK\TwitterAds\Errors\ServerError;
use Hborras\TwitterAdsSDK\TwitterAds\Errors\ServiceUnavailable;
use Hborras\TwitterAdsSDK\Util\JsonDecoder;
use GuzzleHttp;

/**
 * TwitterAds class for interacting with the Twitter API.
 *
 * @author Hector Borras <hborrasaleixandre@gmail.com>
 */
class TwitterAds extends Config
{
    const API_VERSION      = '1';
    const API_HOST         = 'https://ads-api.twitter.com';
    const API_HOST_SANDBOX = 'https://ads-api-sandbox.twitter.com';
    const API_HOST_OAUTH   = 'https://api.twitter.com';
    const UPLOAD_HOST      = 'https://upload.twitter.com';
    const UPLOAD_CHUNK     = 40960; // 1024 * 40

    /** @var  string Method used for the request */
    private $method;
    /** @var  string Resource used for the request */
    private $resource;
    /** @var Response details about the result of the last request */
    private $response;
    /** @var string|null Application bearer token */
    private $bearer;
    /** @var Consumer Twitter application details */
    private $consumer;
    /** @var Token|null User access token details */
    private $token;
    /** @var HmacSha1 OAuth 1 signature type used by Twitter */
    private $signatureMethod;
    /** @var  bool Sandbox allows to make requests thought sandbox environment */
    private $sandbox;

    /**
     * Constructor.
     *
     * @param string $consumerKey The Application Consumer Key
     * @param string $consumerSecret The Application Consumer Secret
     * @param string|null $oauthToken The Client Token (optional)
     * @param string|null $oauthTokenSecret The Client Token Secret (optional)
     * @param bool $sandbox The Sandbox environment (optional)
     */
    public function __construct($consumerKey, $consumerSecret, $oauthToken = null, $oauthTokenSecret = null, $sandbox = false)
    {
        $this->resetLastResponse();
        $this->signatureMethod = new HmacSha1();
        $this->consumer = new Consumer($consumerKey, $consumerSecret);
        if (!empty($oauthToken) && !empty($oauthTokenSecret)) {
            $this->token = new Token($oauthToken, $oauthTokenSecret);
        }
        if (empty($oauthToken) && !empty($oauthTokenSecret)) {
            $this->bearer = $oauthTokenSecret;
        }
        $this->sandbox = $sandbox;
    }

    /**
     * @param string $accountId
     *
     * @return Account|Cursor
     */
    public function getAccounts($accountId = '')
    {
        $account = new Account($this);

        return $accountId ? $account->load($accountId) : $account->all();
    }

    /**
     * @param string $oauthToken
     * @param string $oauthTokenSecret
     */
    public function setOauthToken($oauthToken, $oauthTokenSecret)
    {
        $this->token = new Token($oauthToken, $oauthTokenSecret);
    }

    /**
     * @return string|null
     */
    public function getLastApiPath()
    {
        return $this->response->getApiPath();
    }

    /**
     * @return int
     */
    public function getLastHttpCode()
    {
        return $this->response->getHttpCode();
    }

    /**
     * @return array
     */
    public function getLastXHeaders()
    {
        return $this->response->getXHeaders();
    }

    /**
     * @return array|object|null
     */
    public function getLastBody()
    {
        return $this->response->getBody();
    }

    /**
     * Resets the last response cache.
     */
    public function resetLastResponse()
    {
        $this->response = new Response();
    }

    /**
     * Make URLs for user browser navigation.
     *
     * @param string $path
     * @param array $parameters
     *
     * @return string
     */
    public function url($path, array $parameters)
    {
        $this->resetLastResponse();
        $this->response->setApiPath($path);
        $query = http_build_query($parameters);

        return sprintf('%s/%s?%s', self::API_HOST_OAUTH, $path, $query);
    }

    /**
     * Make /oauth/* requests to the API.
     *
     * @param string $path
     * @param array $parameters
     * @return array
     * @throws Exception
     */
    public function oauth($path, array $parameters = [])
    {
        $response = [];
        $this->resetLastResponse();
        $this->response->setApiPath($path);
        $url = sprintf('%s/%s', self::API_HOST_OAUTH, $path);
        $result = $this->oAuthRequest($url, 'POST', $parameters);

        if ($this->getLastHttpCode() != 200) {
            throw new TwitterAdsException($result, 500, null, $result);
        }

        parse_str($result, $response);
        $this->response->setBody($response);

        return $response;
    }

    /**
     * Make /oauth2/* requests to the API.
     *
     * @param string $path
     * @param array $parameters
     *
     * @return array|object
     */
    public function oauth2($path, array $parameters = [])
    {
        $method = 'POST';
        $this->resetLastResponse();
        $this->response->setApiPath($path);
        $url = sprintf('%s/%s', self::API_HOST_OAUTH, $path);
        $request = Request::fromConsumerAndToken($this->consumer, $this->token, $method, $url, $parameters);
        $authorization = 'Authorization: Basic '.$this->encodeAppAuthorization($this->consumer);
        $result = $this->request($request->getNormalizedHttpUrl(), $method, $authorization, $parameters);
        $response = JsonDecoder::decode($result, $this->decodeJsonAsArray);
        $this->response->setBody($response);

        return $response;
    }

    public function verifyCredentials($parameters = [])
    {
        return $this->http('GET', self::API_HOST_OAUTH, 'account/verify_credentials', $parameters);
    }

    /**
     * Make GET requests to the API.
     *
     * @param string $path
     * @param array $parameters
     *
     * @return array|object
     */
    public function get($path, array $parameters = [])
    {
        return $this->http('GET', !$this->sandbox ? self::API_HOST : self::API_HOST_SANDBOX, $path, $parameters);
    }

    /**
     * Make POST requests to the API.
     *
     * @param string $path
     * @param array $parameters
     *
     * @param array $headers
     * @return array|object
     */
    public function post($path, array $parameters = [], array $headers = [])
    {
        return $this->http('POST', !$this->sandbox ? self::API_HOST : self::API_HOST_SANDBOX, $path, $parameters, $headers);
    }

    /**
     * Make DELETE requests to the API.
     *
     * @param string $path
     * @param array $parameters
     *
     * @return array|object
     */
    public function delete($path, array $parameters = [])
    {
        return $this->http('DELETE', !$this->sandbox ? self::API_HOST : self::API_HOST_SANDBOX, $path, $parameters);
    }

    /**
     * Make PUT requests to the API.
     *
     * @param string $path
     * @param array $parameters
     *
     * @return array|object
     */
    public function put($path, array $parameters = [])
    {
        return $this->http('PUT', !$this->sandbox ? self::API_HOST : self::API_HOST_SANDBOX, $path, $parameters);
    }

    /**
     * Upload media to upload.twitter.com.
     *
     * @param string $path
     * @param array $parameters
     * @param bool $chunked
     *
     * @return array|object
     */
    public function upload($path, array $parameters = [], $chunked = false)
    {
        if ($chunked) {
            return $this->uploadMediaChunked($path, $parameters);
        } else {
            return $this->uploadMediaNotChunked($path, $parameters);
        }
    }

    /**
     * Private method to upload media (not chunked) to upload.twitter.com.
     *
     * @param string $path
     * @param array $parameters
     *
     * @return array|object
     */
    private function uploadMediaNotChunked($path, $parameters)
    {
        $file = file_get_contents($parameters['media']);
        $base = base64_encode($file);
        $parameters['media'] = $base;

        return $this->http('POST', self::UPLOAD_HOST, $path, $parameters);
    }

    /**
     * Private method to upload media (chunked) to upload.twitter.com.
     *
     * @param string $path
     * @param array $parameters
     *
     * @return array|object
     */
    private function uploadMediaChunked($path, $parameters)
    {
        // Init
        $init = $this->http(
            'POST',
            self::UPLOAD_HOST,
            $path,
            [
                'command' => 'INIT',
                'media_type' => $parameters['media_type'],
                'total_bytes' => filesize($parameters['media']),
            ]
        );
        // Append
        $segment_index = 0;
        $media = fopen($parameters['media'], 'rb');
        while (!feof($media)) {
            $this->http(
                'POST',
                self::UPLOAD_HOST,
                'media/upload',
                [
                    'command' => 'APPEND',
                    'media_id' => $init->media_id_string,
                    'segment_index' => $segment_index++,
                    'media_data' => base64_encode(fread($media, self::UPLOAD_CHUNK)),
                ]
            );
        }
        fclose($media);
        // Finalize
        $finalize = $this->http(
            'POST',
            self::UPLOAD_HOST,
            'media/upload',
            [
                'command' => 'FINALIZE',
                'media_id' => $init->media_id_string,
            ]
        );

        return $finalize;
    }

    /**
     * @param string $method
     * @param string $host
     * @param string $path
     * @param array $parameters
     * @return resource
     * @throws BadRequest
     * @throws Forbidden
     * @throws NotAuthorized
     * @throws NotFound
     * @throws RateLimit
     * @throws ServerError
     * @throws ServiceUnavailable
     */
    private function http($method, $host, $path, array $parameters, $headers = [])
    {
        $this->method = $method;
        $this->resource = $path;
        $this->resetLastResponse();
        if($path == 'https://ton.twitter.com/1.1/ton/bucket/ta_partner'){
            $url = $path;
        } else {
            $url = sprintf('%s/%s/%s', $host, self::API_VERSION, $path);
        }

        $this->response->setApiPath($path);
        $result = $this->oAuthRequest($url, $method, $parameters, $headers);
        $response = JsonDecoder::decode($result, $this->decodeJsonAsArray);
        $this->response->setBody($response);
        if ($this->getLastHttpCode() > 399) {
            $this->manageErrors($response);
        }

        return $response;
    }

    /**
     * @param $response
     * @throws BadRequest
     * @throws Forbidden
     * @throws NotAuthorized
     * @throws NotFound
     * @throws RateLimit
     * @throws ServerError
     * @throws ServiceUnavailable
     */
    public function manageErrors($response){
        switch ($this->getLastHttpCode()) {
            case 400:
                throw new BadRequest(TwitterAdsException::BAD_REQUEST, 400, null, $response->errors);
            case 401:
                throw new NotAuthorized(TwitterAdsException::NOT_AUTHORIZED, 401, null, $response->errors);
            case 403:
                throw new Forbidden(TwitterAdsException::FORBIDDEN, 403, null, $response->errors);
            case 404:
                throw new NotFound(TwitterAdsException::NOT_FOUND, 404, null, $response->errors);
            case 429:
                throw new RateLimit(TwitterAdsException::RATE_LIMIT, 429, null, $response->errors, $this->response->getsHeaders());
            case 500:
                throw new ServerError(TwitterAdsException::SERVER_ERROR, 500, null, $response->errors);
            case 503:
                throw new ServiceUnavailable(TwitterAdsException::SERVICE_UNAVAILABLE, 503, null, $response->errors, $this->response->getsHeaders());
            default:
                throw new ServerError(TwitterAdsException::SERVER_ERROR, 500, null, $response->errors);
        }
    }

    /**
     * Format and sign an OAuth / API request.
     *
     * @param string $url
     * @param string $method
     * @param array $parameters
     *
     * @param array $headers
     * @return string
     * @throws TwitterAdsException
     * @throws TwitterOAuthException
     */
    private function oAuthRequest($url, $method, array $parameters, $headers = [])
    {
        $request = Request::fromConsumerAndToken($this->consumer, $this->token, $method, $url, $parameters);
        if (array_key_exists('oauth_callback', $parameters)) {
            // Twitter doesn't like oauth_callback as a parameter.
            unset($parameters['oauth_callback']);
        }
        if ($this->bearer === null) {
            $request->signRequest($this->signatureMethod, $this->consumer, $this->token);
            $authorization = $request->toHeader();
        } else {
            $authorization = 'Authorization: Bearer '.$this->bearer;
        }

        return $this->request($request->getNormalizedHttpUrl(), $method, $authorization, $parameters, $headers);
    }

    /**
     * Make an HTTP request.
     *
     * @param string $url
     * @param string $method
     * @param string $authorization
     * @param array $postfields
     *
     * @param array $headers
     * @return string
     * @throws TwitterAdsException
     */
    private function request($url, $method, $authorization, $postfields, $headers = [])
    {
        /* Curl settings */
        $options = [
            CURLOPT_VERBOSE => false,
            CURLOPT_CAINFO => __DIR__.DIRECTORY_SEPARATOR.'cacert.pem',
            CURLOPT_CONNECTTIMEOUT => $this->connectionTimeout,
            CURLOPT_HEADER => true,
            CURLOPT_HTTPHEADER => array_merge(['Accept: application/json', $authorization, 'Expect:'],$headers),
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_SSL_VERIFYHOST => 2,
            CURLOPT_SSL_VERIFYPEER => true,
            CURLOPT_TIMEOUT => $this->timeout,
            CURLOPT_URL => $url,
            CURLOPT_USERAGENT => $this->userAgent,
            CURLOPT_ENCODING => 'gzip',
        ];

        if (!empty($this->proxy)) {
            $options[CURLOPT_PROXY] = $this->proxy['CURLOPT_PROXY'];
            $options[CURLOPT_PROXYUSERPWD] = $this->proxy['CURLOPT_PROXYUSERPWD'];
            $options[CURLOPT_PROXYPORT] = $this->proxy['CURLOPT_PROXYPORT'];
            $options[CURLOPT_PROXYAUTH] = CURLAUTH_BASIC;
            $options[CURLOPT_PROXYTYPE] = CURLPROXY_HTTP;
        }

        switch ($method) {
            case 'GET':
                break;
            case 'POST':
                $options[CURLOPT_POST] = true;
                if(isset($postfields['raw'])){
                    $options[CURLOPT_POSTFIELDS] = $postfields['raw'];
                } else {
                    $options[CURLOPT_POSTFIELDS] = Util::buildHttpQuery($postfields);
                }

                break;
            case 'DELETE':
                $options[CURLOPT_CUSTOMREQUEST] = 'DELETE';
                break;
            case 'PUT':
                $options[CURLOPT_CUSTOMREQUEST] = 'PUT';
                break;
        }

        if (in_array($method, ['GET', 'PUT', 'DELETE']) && !empty($postfields)) {
            $options[CURLOPT_URL] .= '?'.Util::buildHttpQuery($postfields);
        }

        $curlHandle = curl_init();
        curl_setopt_array($curlHandle, $options);
        $response = curl_exec($curlHandle);
        // Throw exceptions on cURL errors.
        if (curl_errno($curlHandle) > 0) {
            throw new TwitterAdsException(curl_error($curlHandle), curl_errno($curlHandle), null, null);
        }
        $this->response->setHttpCode(curl_getinfo($curlHandle, CURLINFO_HTTP_CODE));
        $parts = explode("\r\n\r\n", $response);
        $responseBody = array_pop($parts);
        $responseHeader = array_pop($parts);
        $this->response->setHeaders($this->parseHeaders($responseHeader));
        curl_close($curlHandle);
        return $responseBody;
    }

    /**
     * Get the header info to store.
     *
     * @param string $header
     *
     * @return array
     */
    private function parseHeaders($header)
    {
        $headers = [];
        foreach (explode("\r\n", $header) as $line) {
            if (strpos($line, ':') !== false) {
                list($key, $value) = explode(': ', $line);
                $key = str_replace('-', '_', strtolower($key));
                $headers[$key] = trim($value);
            }
        }

        return $headers;
    }

    /**
     * Encode application authorization header with base64.
     *
     * @param Consumer $consumer
     *
     * @return string
     */
    private function encodeAppAuthorization($consumer)
    {
        // TODO: key and secret should be rfc 1738 encoded
        $key = $consumer->key;
        $secret = $consumer->secret;

        return base64_encode($key.':'.$secret);
    }

    /**
     * Return current response. Allows inheritance.
     *
     * @return Response
     */
    public function getResponse()
    {
        return $this->response;
    }

    /**
     * @return string
     */
    public function getMethod()
    {
        return $this->method;
    }

    /**
     * @return string
     */
    public function getResource()
    {
        return $this->resource;
    }
}
