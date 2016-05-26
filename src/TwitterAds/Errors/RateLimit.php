<?php

namespace Hborras\TwitterAdsSDK\TwitterAds\Errors;

use Exception;
use Hborras\TwitterAdsSDK\TwitterAdsException;

class RateLimit extends TwitterAdsException
{
    private $retryAfter;
    private $resetAt;

    public function __construct($message, $code, Exception $previous = null, $errors, $headers)
    {
        parent::__construct($message, $code, null, $errors);
        $this->retryAfter = $headers['retry-after'];
        $this->resetAt = $headers['rate_limit_reset'];
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
