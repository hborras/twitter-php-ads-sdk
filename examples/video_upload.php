<?php

use Hborras\TwitterAdsSDK\TwitterAds;
use Hborras\TwitterAdsSDK\TwitterAds\Account;
use Hborras\TwitterAdsSDK\TwitterAds\Creative\Video;

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

/** Upload media */
$media = $twitterAds->upload(['media' => 'video.mp4', 'media_type' => 'video/mp4'], true);

/** Create a video entity and save it*/
$video = new Video($account);
$video->setTitle("Test Video " . rand());
$video->setDescription("Description" . rand());
$video->setVideoMediaId($media->media_id);
$video->save();
