<?php

namespace Hborras\TwitterAdsSDK\TwitterAds\Errors;

use Exception;
use Hborras\TwitterAdsSDK\TwitterAdsException;

/**
 * Class ServerError
 * @package Hborras\TwitterAdsSDK\TwitterAds\Errors
 */
class ServerError extends TwitterAdsException
{
    /**
     * ServerError constructor.
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
