<?php

use Hborras\TwitterAdsSDK\TwitterAds;
use Hborras\TwitterAdsSDK\TwitterAds\Account;


require '../autoload.php';

const CONSUMER_KEY = 'your consumer key';
const CONSUMER_SECRET = 'your consumer secret';
const ACCESS_TOKEN = 'your access token';
const ACCESS_TOKEN_SECRET = 'your access token secret';
const ACCOUNT_ID = 'account id';

/** Create twitter ads client */
$api = TwitterAds::init(CONSUMER_KEY, CONSUMER_SECRET, ACCESS_TOKEN, ACCESS_TOKEN_SECRET);


// Retrieve account information
$account = new Account(ACCOUNT_ID);
$account->read();

$tailoredAudiences = $account->getTailoredAudiences();

$tailoredAudiences->setDefaultUseImplicitFetch(true);

foreach ($tailoredAudiences as $tailoredAudience) {
    echo $tailoredAudience->getName().PHP_EOL;
}