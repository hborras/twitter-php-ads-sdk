<?php

use Hborras\TwitterAdsSDK\TwitterAds;
use Hborras\TwitterAdsSDK\TwitterAds\Analytics;
use Hborras\TwitterAdsSDK\TwitterAds\Campaign\LineItem;

require '../autoload.php';

const CONSUMER_KEY = 'your consumer key';
const CONSUMER_SECRET = 'your consumer secret';
const ACCESS_TOKEN = 'your access token';
const ACCESS_TOKEN_SECRET = 'your access token secret';
const ACCOUNT_ID = 'account id';

// Create twitter ads client
$twitterAds = new TwitterAds(CONSUMER_KEY, CONSUMER_SECRET, ACCESS_TOKEN, ACCESS_TOKEN_SECRET);

// load up the account instance, campaign and line item
$account = $twitterAds->getAccounts(ACCOUNT_ID);

// Limit request count and grab the first 10 line items from Cursor
$lineItems = $account->getLineItems("", ['count' => 10]);

// The list of metrics we want to fetch, for a full list of possible metrics
$metrics = [Analytics::ANALYTICS_METRIC_GROUPS_ENGAGEMENT, Analytics::ANALYTICS_METRIC_GROUPS_BILLING];

// Fetching stats on the instance
/** @var LineItem $lineItem */
$lineItem = $lineItems->first();
$stats = $lineItem->stats($metrics);

// Fetching stats for multiple line items
$ids = array_map(
    function($o) {
        return $o->getId();
    },
    $lineItems->getCollection()
);

$stats = LineItem::all_stats($account, $ids, $metrics);