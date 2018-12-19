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

$campaignBatch = new Campaign();

// Create your campaign
$campaign = new Campaign();
$campaign->setFundingInstrumentId($account->getFundingInstruments()->first()->getId());
$campaign->setDailyBudgetAmountLocalMicro(1000000);
$campaign->setName("My first campaign: ");
$campaign->setEntityStatus(Campaign::STATUS_PAUSED);
$campaign->setStartTime(new \DateTime());

$campaignBatch->addBatch($campaign);



// Create your campaign
$campaign2 = new Campaign();
$campaign2->setFundingInstrumentId($account->getFundingInstruments()->first()->getId());
$campaign2->setDailyBudgetAmountLocalMicro(1000000);
$campaign2->setName("My second campaign: ");
$campaign2->setPaused(false);
$campaign2->setStartTime(new \DateTime());

$campaignBatch->addBatch($campaign2);

$campaignBatch->saveBatch();

