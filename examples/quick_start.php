<?php

use Hborras\TwitterAdsSDK\TwitterAds;
use Hborras\TwitterAdsSDK\TwitterAds\Account;
use Hborras\TwitterAdsSDK\TwitterAds\Campaign\Campaign;
use Hborras\TwitterAdsSDK\TwitterAds\Campaign\LineItem;
use Hborras\TwitterAdsSDK\TwitterAds\Campaign\TargetingCriteria;
use Hborras\TwitterAdsSDK\TwitterAds\Enumerations;

require '../autoload.php';

const CONSUMER_KEY = 'your consumer key';
const CONSUMER_SECRET = 'your consumer secret';
const ACCESS_TOKEN = 'your access token';
const ACCESS_TOKEN_SECRET = 'your access token secret';
const ACCOUNT_ID = 'account id';

// Create twitter ads client
$twitterAds = new TwitterAds(CONSUMER_KEY, CONSUMER_SECRET, ACCESS_TOKEN, ACCESS_TOKEN_SECRET);

// Retrieve account information
$account = new Account(ACCOUNT_ID);

// Create your campaign
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

// Add targeting criteria
$targetingCriteria = new TargetingCriteria($account);
$targetingCriteria->setLineItemId($lineItem->getId());
$targetingCriteria->setTargetingType('LOCATION');
$targetingCriteria->setTargetingValue('00a8b25e420adc94');
$targetingCriteria->save();