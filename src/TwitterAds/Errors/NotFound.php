<?php

namespace Hborras\TwitterAdsSDK\TwitterAds\Errors;

use Exception;
use Hborras\TwitterAdsSDK\TwitterAdsException;

/**
 * Class NotFound
 * @package Hborras\TwitterAdsSDK\TwitterAds\Errors
 */
class NotFound extends TwitterAdsException
{
    /**
     * NotFound constructor.
     * @param $message
     * @param $code
     * @param Exception|null $previous
     * @param $errors
     */
    public function __construct($message, $code, Exception $previous = null, $errors)
    {
        parent::__construct($message, $code, null, $errors);
    }
}
