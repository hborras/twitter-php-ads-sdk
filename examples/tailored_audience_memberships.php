<?php

use Hborras\TwitterAdsSDK\TwitterAds;
use Hborras\TwitterAdsSDK\TwitterAds\TailoredAudience\TailoredAudienceMemberships;
use Hborras\TwitterAdsSDK\TwitterAds\TailoredAudience\TailoredAudienceMember;;

require '../autoload.php';

const CONSUMER_KEY = 'your consumer key';
const CONSUMER_SECRET = 'your consumer secret';
const ACCESS_TOKEN = 'your access token';
const ACCESS_TOKEN_SECRET = 'your access token secret';
const ACCOUNT_ID = 'account id';

// Create twitter ads client
$twitterAds = new TwitterAds(CONSUMER_KEY, CONSUMER_SECRET, ACCESS_TOKEN, ACCESS_TOKEN_SECRET);

$batch = new TailoredAudienceMemberships($account);

for ($i = 0; $i < 101; $i++) {
    $member = new TailoredAudienceMember();
    //Replace these values with correct ones from
    //https://dev.twitter.com/ads/reference/post/tailored_audience_memberships
    $member->setScore($i);
    $member->setUserIdentifier($i);
    $member->setAdvertiserAccountId(self::ACCOUNT_ID);
    $member->setUserIdentifierType(TailoredAudienceMember::TYPE_TAWEB_PARTNER_USER_ID);
    $member->setAudienceNames([
        'test1',
        'test2',
    ]);
    $batch->add($member);
}

$batch->save();
