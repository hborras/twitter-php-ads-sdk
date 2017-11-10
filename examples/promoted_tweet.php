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

/** @var Campaign $campaign */
$campaign = new Campaign($account);
$campaign->setFundingInstrumentId($account->getFundingInstruments()->first()->getId());
$campaign->setDailyBudgetAmountLocalMicro(1000000);
$campaign->setName("My first campaign: ");
$campaign->setPaused(false);
$campaign->setStartTime(new \DateTime());
$campaign->save();

// Create a line item for the campaign
$lineItem = new LineItem($account);
$lineItem->setCampaignId($campaign->getId());
$lineItem->setName("My first line item: ");
$lineItem->setProductType(Enumerations::PRODUCT_PROMOTED_TWEETS);
$lineItem->setPlacements([Enumerations::PLACEMENT_ALL_ON_TWITTER]);
$lineItem->setObjective(Enumerations::OBJECTIVE_TWEET_ENGAGEMENTS);
$lineItem->setBidAmountLocalMicro(10000);
$lineItem->setPaused(false);
$lineItem->save();

// create request for a simple nullcasted tweet
$media = $twitterAds->upload(['media' => 'kitten.jpg']);
$tweet1 = Tweet::create($account, 'Tweet number 1 ...' . rand() . ' http://twitter.com', ['media_ids' => $media->media_id]);

// promote the tweet using our line item
$promotedTweet = new PromotedTweet($account);
$promotedTweet->setLineItemId($lineItem->getId());
$promotedTweet->setTweetId($tweet1->id);
$promotedTweet->save();

// create request for a nullcasted tweet with a website card
$websiteCard = new WebsiteCard($account);
$websiteCard = $websiteCard->all()->next();
$status = 'Tweet number 2 ...' . rand() . $websiteCard->getPreviewUrl();

$tweet2 = Tweet::create($account, $status);

// Promote the tweet using our line item
$promotedTweet = new PromotedTweet($account);
$promotedTweet->setLineItemId($lineItem->getId());
$promotedTweet->setTweetId($tweet2->id);
$promotedTweet->save();