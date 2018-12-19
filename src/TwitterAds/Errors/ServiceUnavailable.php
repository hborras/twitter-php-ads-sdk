<?php

namespace Hborras\TwitterAdsSDK\TwitterAds\Errors;

use Exception;
use Hborras\TwitterAdsSDK\TwitterAdsException;

class ServiceUnavailable extends TwitterAdsException
{
    private $retryAfter;

    public function __construct($message, $code, $errors, $headers)
    {
        parent::__construct($message, $code, null, $errors);
        $this->retryAfter = $headers['retry-after'];
    }

    /**
     * @return mixed
     */
    public function getRetryAfter()
    {
        return $this->retryAfter;
    }
}
