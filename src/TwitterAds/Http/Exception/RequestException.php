<?php

namespace Hborras\TwitterAdsSDK\TwitterAds\Http\Exception;

use Hborras\TwitterAdsSDK\TwitterAds\Exception\Exception;
use Hborras\TwitterAdsSDK\TwitterAds\Http\Headers;
use Hborras\TwitterAdsSDK\TwitterAds\Http\ResponseInterface;

class RequestException extends Exception
{

    /**
     * @var ResponseInterface|null
     */
    protected $response;

    /**
     * @var Headers
     */
    protected $headers;

    /**
     * @var int|null
     */
    protected $errorCode;

    /**
     * @var string|null
     */
    protected $errorMessage;

    /**
     * @var array
     */
    protected $errors;

    /**
     * @param ResponseInterface $response
     */
    public function __construct(ResponseInterface $response)
    {
        $this->headers = $response->getHeaders();
        $this->response = $response;
        $errorData = static::getErrorData($response);

        parent::__construct($errorData['errors'][0]['subcode'], $errorData['code']);
        $this->errorCode = $errorData['code'];
        $this->errorMessage = $errorData['errors'][0]['message'];
        $this->errors = $errorData['errors'];
    }

    /**
     * @return ResponseInterface|null
     */
    public function getResponse()
    {
        return $this->response;
    }

    /**
     * @param array|string $array
     * @param string|int $key
     * @param mixed $default
     * @return mixed
     */
    protected static function idx($array, $key, $default = null)
    {
        if (is_string($array)) {
            $array = json_decode($array, true);
        }
        return array_key_exists($key, $array)
            ? $array[$key]
            : $default;
    }

    /**
     * @param ResponseInterface $response
     * @return array
     */
    protected static function getErrorData(ResponseInterface $response)
    {
        $response_data = $response->getContent();
        if (is_null($response_data)) {
            $response_data = array();
        }
        $errors = static::idx($response_data, 'errors', array());
        $errorData = [
            'code' => $response->getStatusCode(),
            'errors' => []
        ];
        foreach ($errors as $error) {

            $errorData['errors'][] = [
                'subcode' => static::idx($error, 'code'),
                'message' => static::idx($error, 'message'),
                'parameter' => static::idx($error, 'parameter'),
                'details' => static::idx($error, 'details'),
                'value' => static::idx($error, 'value'),
            ];
        }

        return $errorData;
    }

    /**
     * Process an error payload from the Graph API and return the appropriate
     * exception subclass.
     * @param ResponseInterface $response
     * @return RequestException
     */
    public static function create(ResponseInterface $response)
    {
        $errorData = static::getErrorData($response);
        if ($errorData['code']  === 400) {
            return new BadRequestException($response);
        } elseif ($errorData['code']  >=  401) {
            return new AuthorizationException($response);
        } elseif ($errorData['code']  >=  403) {
            return new AuthorizationException($response);
        } elseif ($errorData['code']  >=  404) {
            return new AuthorizationException($response);
        } elseif ($errorData['code']  >=  429) {
            return new RateLimitException($response);
        } elseif ($errorData['code']  >=  500) {
            return new ServerException($response);
        } elseif ($errorData['code']  >=  503) {
            return new ServiceUnavailableException($response);
        } else {
            return new self($response);
        }
    }

    /**
     * @return int
     */
    public function getHttpStatusCode()
    {
        return $this->response->getStatusCode();
    }

    /**
     * @return int|null
     */
    public function getErrorCode()
    {
        return $this->errorCode;
    }

    /**
     * @return string|null
     */
    public function getErrorMessage()
    {
        return $this->errorMessage;
    }

    /**
     * @return string|null
     */
    public function getErrors()
    {
        return $this->errors;
    }

    /**
     * @return Headers
     */
    public function getHeaders()
    {
        return $this->headers;
    }
}
