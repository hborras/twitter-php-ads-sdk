<?php

namespace Hborras\TwitterAdsSDK;

use Exception;

/**
 * @author Hector Borras <hborrasaleixandre@gmail.com>
 */
class TwitterAdsException extends \Exception
{
    private $response;
    private $code;
    private $message;
    private $details;

    public function __construct($message, $code, Exception $previous = null, $response, $details)
    {
        parent::__construct($message, $code, $previous);
        $this->response = $response;
        $this->details =  $details;
    }

    /**
     * @return mixed
     */
    public function getResponse()
    {
        return $this->response;
    }

    /**
     * @return mixed
     */
    public function getDetails()
    {
        return $this->details;
    }
}
