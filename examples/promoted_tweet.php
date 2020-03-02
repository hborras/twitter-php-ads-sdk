<?php

use Hborras\TwitterAdsSDK\TwitterAds;
use Hborras\TwitterAdsSDK\TwitterAds\Account;
use Hborras\TwitterAdsSDK\TwitterAds\Campaign\Campaign;
use Hborras\TwitterAdsSDK\TwitterAds\Campaign\LineItem;
use Hborras\TwitterAdsSDK\TwitterAds\Campaign\Tweet;
use Hborras\TwitterAdsSDK\TwitterAds\Creative\PromotedTweet;
use Hborras\TwitterAdsSDK\TwitterAds\Creative\WebsiteCard;
use Hborras\TwitterAdsSDK\TwitterAds\Enumerations;
use Hborras\TwitterAdsSDK\TwitterAds\Fields\TweetFields;

require '../autoload.php';

const CONSUMER_KEY = 'your consumer key';
const CONSUMER_SECRET = 'your consumer secret';
const ACCESS_TOKEN = 'your access token';
const ACCESS_TOKEN_SECRET = 'your access token secret';
const ACCOUNT_ID = 'account id';

// Create twitter ads client
$api = TwitterAds::init(CONSUMER_KEY, CONSUMER_SECRET, ACCESS_TOKEN, ACCESS_TOKEN_SECRET);

// Retrieve account information
$account = new Account(ACCOUNT_ID);
$account->read();

$fundingInstruments = $account->getFundingInstruments();
$fundingInstrument = $fundingInstruments->getCollection()[0];

// Create your campaign
$campaign = new Campaign();
$campaign->setFundingInstrumentId($fundingInstrument->getId());
$campaign->setDailyBudgetAmountLocalMicro(1000000);
$campaign->setName("My first campaign: ");
$campaign->setEntityStatus('PAUSED');
$campaign->setStartTime(new \DateTime());
$campaign->save();

// Create a line item for the campaign
$lineItem = new LineItem();
$lineItem->setCampaignId($campaign->getId());
$lineItem->setName("My first line item: ");
$lineItem->setProductType(Enumerations::PRODUCT_PROMOTED_TWEETS);
$lineItem->setPlacements([Enumerations::PLACEMENT_ALL_ON_TWITTER]);
$lineItem->setObjective(Enumerations::OBJECTIVE_TWEET_ENGAGEMENTS);
$lineItem->setBidAmountLocalMicro(10000);
$lineItem->setEntityStatus('PAUSED');
$lineItem->save();

// Add targeting criteria
$targetingCriteria = new TargetingCriteria();
$targetingCriteria->setLineItemId($lineItem->getId());
$targetingCriteria->setTargetingType('LOCATION');
$targetingCriteria->setTargetingValue('00a8b25e420adc94');
$targetingCriteria->save();

// create request for a simple nullcasted tweet
$media = $api->upload(['media' => 'kitten.jpg']);
$tweet1 = Tweet::create($account, 'Tweet number 1 ...' . rand() . ' http://twitter.com', ['media_ids' => $media->media_id]);

// promote the tweet using our line item
$promotedTweet = new PromotedTweet();
$promotedTweet->setLineItemId($lineItem->getId());
$promotedTweet->setTweetId($tweet1->id);
$promotedTweet->save();

// create request for a nullcasted tweet with a website card
$websiteCard = new WebsiteCard();
$websiteCard = $websiteCard->all()->getCollection()[0];
$status = 'Tweet number 2 ...' . rand();

$tweet2 = Tweet::create($account, $status, [TweetFields::CARD_URI => $websiteCard->getCardUri()]);

// Promote the tweet using our line item
$promotedTweet = new PromotedTweet();
$promotedTweet->setLineItemId($lineItem->getId());
$promotedTweet->setTweetId($tweet2->id);
$promotedTweet->save();