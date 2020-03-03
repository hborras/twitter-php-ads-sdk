<?php

use Hborras\TwitterAdsSDK\TwitterAds;
use Hborras\TwitterAdsSDK\TwitterAds\Account;
use Hborras\TwitterAdsSDK\TwitterAds\Campaign\Campaign;
use Hborras\TwitterAdsSDK\TwitterAds\Campaign\LineItem;
use Hborras\TwitterAdsSDK\TwitterAds\Enumerations;
use Hborras\TwitterAdsSDK\TwitterAds\Fields\AnalyticsFields;
use Hborras\TwitterAdsSDK\TwitterAdsException;

require '../autoload.php';

const CONSUMER_KEY = 'your consumer key';
const CONSUMER_SECRET = 'your consumer secret';
const ACCESS_TOKEN = 'your access token';
const ACCESS_TOKEN_SECRET = 'your access token secret';
const ACCOUNT_ID = 'account id';

// Create Twitter Ads Api Instance
$api = TwitterAds::init(CONSUMER_KEY, CONSUMER_SECRET, ACCESS_TOKEN, ACCESS_TOKEN_SECRET);

// load up the account instance, campaign and line item
$account = new Account(ACCOUNT_ID);
$account->read();
$campaigns = $account->getCampaigns('', [TwitterAds\Fields\CampaignFields::COUNT => 1]);
$campaigns->setUseImplicitFetch(false);
$campaignsData = [];


/** @var Campaign $campaign */
foreach ($campaigns as $campaign) {
    $campaignsData[] = $campaign;
}

$i = 1;
$j = 1;
$l = 1;
foreach ($campaignsData as $campaign) {
    echo $i . ': ' . $campaign->getId() . ' ' . $campaign->getName() . ' ' . $campaign->getStartTime()->format('Y-m-d') . ' - ' . $campaign->getEntityStatus() . PHP_EOL;
    $lineItems = $campaign->getLineItems([TwitterAds\Fields\LineItemFields::COUNT => 2]);
    /** @var LineItem $lineItem */
    foreach ($lineItems as $lineItem) {
        echo "\t" . $j . ': ' . $lineItem->getId() . ' ' . $lineItem->getName() . ' ' . PHP_EOL;
        echo "\t\tBid: " . ($lineItem->getBidAmountLocalMicro() / 1000000) . PHP_EOL;
        echo "\t\tObjective: " . $lineItem->getObjective() . PHP_EOL;
        echo "\t\tCharge By: " . $lineItem->getChargeBy() . PHP_EOL;
        echo "\t\tBid Unit: " . $lineItem->getBidUnit() . PHP_EOL;
        echo "\t\tOptimization: " . $lineItem->getOptimization() . PHP_EOL;
        echo "\t\tBid Type: " . $lineItem->getBidType() . PHP_EOL;
        $targetingCriterias = $lineItem->getTargetingCriteria();
        /** @var TwitterAds\Campaign\TargetingCriteria $targetingCriteria */
        foreach ($targetingCriterias as $targetingCriteria) {
            echo "\t\t" . $l . ': ' . $targetingCriteria->getId() . ' ' . $targetingCriteria->getName() . ' ' .

                $targetingCriteria->getTargetingType() . ' ' . $targetingCriteria->getTargetingValue() . PHP_EOL;

            $l++;
        }
        $l = 1;
        try {
            $async = false;
            $startDate = new DateTime($campaign->getStartTime()->format('Y-m-d 00:00:00'));
            $endDate = new DateTime('now');
            $dates = dateRanges($startDate, $endDate);
            foreach ($dates as $date) {
                $stats = $lineItem->stats(
                    [
                        TwitterAds\Fields\AnalyticsFields::METRIC_GROUPS_BILLING,
                        TwitterAds\Fields\AnalyticsFields::METRIC_GROUPS_MOBILE_CONVERSION,
                        TwitterAds\Fields\AnalyticsFields::METRIC_GROUPS_ENGAGEMENT,
                    ],
                    [
                        TwitterAds\Fields\AnalyticsFields::START_TIME => $date[0],
                        AnalyticsFields::END_TIME => $date[1],
                        AnalyticsFields::GRANULARITY => Enumerations::GRANULARITY_TOTAL,
                        AnalyticsFields::PLACEMENT => Enumerations::PLACEMENT_ALL_ON_TWITTER
                    ], $async
                );
                $stats = $stats[0]->id_data[0]->metrics;
                if (!is_null($stats->billed_charge_local_micro)) {
                    echo "\t\t\t Start: " . $date[0]->format('Y-m-d H:i:s') . PHP_EOL;
                    echo "\t\t\t End: " . $date[1]->format('Y-m-d H:i:s') . PHP_EOL;
                    echo "\t\t\t " . ($stats->billed_charge_local_micro[0] / 1000000) . '€' . PHP_EOL;
                    echo "\t\t\t\t App clicks: ";
                    getStats($stats->app_clicks);
                    echo "\t\t\t\t Installs:" . PHP_EOL;
                    getStats($stats->mobile_conversion_installs);
                    echo "\t\t\t\t Checkouts:" . PHP_EOL;
                    getStats($stats->mobile_conversion_checkouts_initiated);
                }
            }

        } catch (TwitterAdsException $e) {
            print_r($e->getErrors());
        }

        $j++;
    }
    $j = 1;
    $i++;
}

function getStats($stat)
{
    if ($stat instanceof stdClass) {
        foreach (get_object_vars($stat) as $key => $val) {
            if (is_array($val)) {
                echo "\t\t\t\t\t " . $key . ': ' . $val[0] . PHP_EOL;
            } else {
                echo "\t\t\t\t\t " . $key . ' 0' . PHP_EOL;
            }
        }
    } else if (is_array($stat)) {
        foreach ($stat as $s) {
            echo $s . PHP_EOL;
        }
    }

}

/**
 * @param $startTime
 * @param $endTime
 * @return array
 * @throws Exception
 */
function dateRanges($startTime, $endTime)
{
    $interval = new DateInterval('P7D');
    $dateRange = new DatePeriod($startTime, $interval, $endTime);

    $previous = null;
    $dates = array();
    foreach ($dateRange as $dt) {
        $current = $dt;
        if (!empty($previous)) {
            $show = $current;
            $dates[] = array($previous, $show);
        }
        $previous = $current;
    }
    if (isset($dates[count($dates) - 1])) {
        $dates[] = array($dates[count($dates) - 1][1], $endTime);
    } else {
        $dates[] = array($startTime, $endTime);
    }

    return $dates;
}