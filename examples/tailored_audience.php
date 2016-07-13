<?php

use Hborras\TwitterAdsSDK\TONUpload;
use Hborras\TwitterAdsSDK\TwitterAds;


require '../autoload.php';

const CONSUMER_KEY = 'your consumer key';
const CONSUMER_SECRET = 'your consumer secret';
const ACCESS_TOKEN = 'your access token';
const ACCESS_TOKEN_SECRET = 'your access token secret';
const ACCOUNT_ID = 'account id';
// Create twitter ads client
$twitterAds = new TwitterAds(CONSUMER_KEY, CONSUMER_SECRET, ACCESS_TOKEN, ACCESS_TOKEN_SECRET);

try{
    $tonUpload = new TONUpload($twitterAds,'../list.txt');
    $location = $tonUpload->perform();
    var_dump($location);
} catch (Exception $e){
    var_dump($e->getCode(), $e->getMessage());
}

