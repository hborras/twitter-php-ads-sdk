<?php

use Hborras\TwitterAdsSDK\TwitterAds;
use Hborras\TwitterAdsSDK\TwitterAds\Account;
use Hborras\TwitterAdsSDK\TwitterAds\TailoredAudience\TailoredAudience;


require '../autoload.php';

const CONSUMER_KEY = 'your consumer key';
const CONSUMER_SECRET = 'your consumer secret';
const ACCESS_TOKEN = 'your access token';
const ACCESS_TOKEN_SECRET = 'your access token secret';
const ACCOUNT_ID = 'account id';

/** Create twitter ads client */
$api = TwitterAds::init(CONSUMER_KEY, CONSUMER_SECRET, ACCESS_TOKEN, ACCESS_TOKEN_SECRET);

/** If the file is too large, I highly recommend increase the timeout */
$api->setTimeouts(5, 45);

// Retrieve account information
$account = new Account(ACCOUNT_ID);
$account->read();

/** If the file is not hashed line by line, you need to hash it, for example for emails is this code*/

$file = fopen("list.txt", "r");
$newFile = fopen('new_list.txt', 'w');
while (!feof($file)) {
    $line = fgets($file);
    $normalized_email = strtolower(trim($line, " \t\r\n\0\x0B."));
    $normalized_email = hash('sha256', $normalized_email);
    fwrite($newFile, $normalized_email . "\n");
    # do same stuff with the $line
}
fclose($newFile);
fclose($file);
$audience = new TailoredAudience();
$audience->create('new_list.txt', 'Test List', TailoredAudience::LIST_TYPE_EMAIL);

/** @var TwitterAds\TailoredAudience\TailoredAudienceChanges $status */
$status = $audience->status();
print_r($status->getState());
