<?php

use Hborras\TwitterAdsSDK\TwitterAds;
use Hborras\TwitterAdsSDK\TwitterAds\TailoredAudience\TailoredAudienceMemberships;
use Hborras\TwitterAdsSDK\TwitterAds\TailoredAudience\TailoredAudienceMember;;

require '../autoload.php';

const CONSUMER_KEY = 'your consumer key';
const CONSUMER_SECRET = 'your consumer secret';
const ACCESS_TOKEN = 'your access token';
const ACCESS_TOKEN_SECRET = 'your access token secret';
const ACCOUNT_ID = 'account id';
// Create twitter ads client
$twitterAds = new TwitterAds(CONSUMER_KEY, CONSUMER_SECRET, ACCESS_TOKEN, ACCESS_TOKEN_SECRET);

try{
    $tonUpload = new \Hborras\TwitterAdsSDK\TONUpload($twitterAds,'../list.txt');
    $tonUpload->perform();
} catch (Exception $e){
    var_dump($e->getCode(), $e->getMessage());
}

