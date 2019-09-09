<?php

namespace Hborras\TwitterAdsSDK\TwitterAds\Errors;

use Exception;
use Hborras\TwitterAdsSDK\TwitterAdsException;

/**
 * Class RateLimit
 * @package Hborras\TwitterAdsSDK\TwitterAds\Errors
 */
class RateLimit extends TwitterAdsException
{
    /**
     * @var mixed
     */
    private $retryAfter;
    /**
     * @var mixed
     */
    private $resetAt;

    /**
     * RateLimit constructor.
     * @param $message
     * @param $code
     * @param Exception|null $previous
     * @param $errors
     * @param $headers
     */
    public function __construct($message, $code, Exception $previous = null, $errors, $headers)
    {
        parent::__construct($message, $code, null, $errors);
        $this->retryAfter = $headers['x_rate_limit_limit'];
        $this->resetAt = $headers['x_rate_limit_reset'];
    }

    /**
     * @return mixed
     */
    public function getRetryAfter()
    {
        return $this->retryAfter;
    }

    /**
     * @return mixed
     */
    public function getResetAt()
    {
        return $this->resetAt;
    }
}
