<?php

use Hborras\TwitterAdsSDK\TwitterAds;
use Hborras\TwitterAdsSDK\TwitterAds\Account;
use Hborras\TwitterAdsSDK\TwitterAds\Analytics;
use Hborras\TwitterAdsSDK\TwitterAds\Campaign\Campaign;
use Hborras\TwitterAdsSDK\TwitterAds\Campaign\LineItem;

require '../autoload.php';

const CONSUMER_KEY = 'your consumer key';
const CONSUMER_SECRET = 'your consumer secret';
const ACCESS_TOKEN = 'your access token';
const ACCESS_TOKEN_SECRET = 'your access token secret';
const ACCOUNT_ID = 'account id';

// Create Twitter Ads Api Instance
$api = TwitterAds::init(CONSUMER_KEY, CONSUMER_SECRET, ACCESS_TOKEN, ACCESS_TOKEN_SECRET);

$accounts = $api->getAccounts();
// load up the account instance, campaign and line item
$account = new Account(ACCOUNT_ID);

$account->read();

$campaigns = $account->getCampaigns('',['count'=> 2, 'sort_by'=> 'created_at-desc']);

$campaignIds = [];
/** @var Campaign $campaign */
foreach ($campaigns as $campaign) {
    $lineItems = $campaign->getLineItems();
    /** @var LineItem $lineItem */
    foreach ($lineItems as $lineItem) {
        $promotedTweets = $lineItem->getPromotedTweets();
    }
}

echo "hi";
