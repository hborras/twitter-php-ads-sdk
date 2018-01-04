<?php
/**
 * Created by PhpStorm.
 * User: hborras
 * Date: 4/01/18
 * Time: 22:34
 */

namespace Hborras\TwitterAdsSDK\TwitterAds\Errors\PromotedTweet;


use Exception;

class PromotedTweetPutNotAllowedException extends Exception
{
    public function __construct()
    {
        parent::__construct(500, 'PromotedTweetPutNotAllowedException');
    }
}