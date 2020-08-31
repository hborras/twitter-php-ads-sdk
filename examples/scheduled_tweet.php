<?php

use Hborras\TwitterAdsSDK\TwitterAds;
use Hborras\TwitterAdsSDK\TwitterAds\Account;
use Hborras\TwitterAdsSDK\TwitterAds\Campaign\ScheduledTweet;

require '../autoload.php';

const CONSUMER_KEY = '';
const CONSUMER_SECRET = '';
const ACCESS_TOKEN = '';
const ACCESS_TOKEN_SECRET = '';
const ACCOUNT_ID = '';
const USER_ID = '';

// Create twitter ads client
$api = TwitterAds::init(CONSUMER_KEY, CONSUMER_SECRET, ACCESS_TOKEN, ACCESS_TOKEN_SECRET);

$account = (new Account(ACCOUNT_ID))->read();

$scheduledTweet = new ScheduledTweet();

$scheduledTweet->setText("This is my Text");
$scheduledTweet->setAsUserId(USER_ID);
$scheduledTweet->setNullcast(true);
$scheduledTweet->setScheduledAt(new DateTime('tomorrow'));

$scheduledTweet->save();