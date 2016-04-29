<?php

use Hborras\TwitterAdsSDK\TwitterAds;
use Hborras\TwitterAdsSDK\TwitterAds\Account;
use Hborras\TwitterAdsSDK\TwitterAds\Campaign\Campaign;
use Hborras\TwitterAdsSDK\TwitterAds\Campaign\Tweet;
use Hborras\TwitterAdsSDK\TwitterAds\Creative\PromotedTweet;
use Hborras\TwitterAdsSDK\TwitterAds\Creative\WebsiteCard;

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
$account = $twitterAds->getAccounts(ACCOUNT_ID);
/** @var Campaign $campaign */
$campaign = $account->getCampaigns()->first();
/** @var LineItem $lineItem */
$lineItem = $account->getLineItems(null, ['campaign_ids' => $campaign->getId()])->next();

// create request for a simple nullcasted tweet
$tweet1 = Tweet::create($account, 'There can be only one...  http://twitter.com');

// promote the tweet using our line item
$promotedTweet = new PromotedTweet($account);
$promotedTweet->setLineItemId($lineItem->getId());
$promotedTweet->setTweetId($tweet1->id);
$promotedTweet->save();

// create request for a nullcasted tweet with a website card
$websiteCard = new WebsiteCard($account);
$websiteCard = $websiteCard->all()->next();
$status = 'Fine. There can be two.  '.$websiteCard->getPreviewUrl();
$tweet2 = Tweet::create($account, $status);

// Promote the tweet using our line item
$promotedTweet = new PromotedTweet($account);
$promotedTweet->setLineItemId($lineItem->getId());
$promotedTweet->setTweetId($tweet2->id);
$promotedTweet->save();