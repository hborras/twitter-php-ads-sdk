<?php

use Hborras\TwitterAdsSDK\TwitterAds;
use Hborras\TwitterAdsSDK\TwitterAds\Account;
use Hborras\TwitterAdsSDK\TwitterAds\Campaign\Campaign;
use Hborras\TwitterAdsSDK\TwitterAds\Campaign\LineItem;
use Hborras\TwitterAdsSDK\TwitterAds\Campaign\Tweet;
use Hborras\TwitterAdsSDK\TwitterAds\Creative\PromotedTweet;
use Hborras\TwitterAdsSDK\TwitterAds\Creative\WebsiteCard;
use Hborras\TwitterAdsSDK\TwitterAds\Enumerations;

require '../autoload.php';

const CONSUMER_KEY = 'your consumer key';
const CONSUMER_SECRET = 'your consumer secret';
const ACCESS_TOKEN = 'your access token';
const ACCESS_TOKEN_SECRET = 'your access token secret';
const ACCOUNT_ID = 'account id';

// Create twitter ads client
$twitterAds = new TwitterAds(CONSUMER_KEY, CONSUMER_SECRET, ACCESS_TOKEN, ACCESS_TOKEN_SECRET);

// load up the account instance, campaign and line item
/** @var Account $account */
$account = new Account(ACCOUNT_ID);

// create request for a simple nullcasted tweet
$media = $twitterAds->upload(['media' => 'twitter-gif.gif', 'media_type' => 'image/gif'], true);
$tweet = Tweet::create($account, 'Tweet with chunked upload GIF...' . rand() . ' http://twitter.com', ['media_ids' => $media->media_id]);