<?php
/**
 * Created by PhpStorm.
 * User: hborras
 * Date: 23/04/16
 * Time: 10:47
 */

namespace Hborras\TwitterAdsSDK\TwitterAds;


class Analytics extends Resource
{

    const ANALYTICS_MAP_LINE_ITEM      = "line_item_ids";
    const ANALYTICS_MAP_ORGANIC_TWEET  = "tweet_ids";
    const ANALYTICS_MAP_TWEET          = "tweet_ids";
    const ANALYTICS_MAP_PROMOTED_TWEET = "promoted_tweet_ids";

    const ANALYTICS_METRIC_GROUPS_ENGAGEMENT                        = "ENGAGEMENT";
    const ANALYTICS_METRIC_GROUPS_BILLING                           = "BILLING";
    const ANALYTICS_METRIC_GROUPS_VIDEO                             = "VIDEO";
    const ANALYTICS_METRIC_GROUPS_MEDIA                             = "MEDIA";
    const ANALYTICS_METRIC_GROUPS_WEB_CONVERSIONS                   = "WEB_CONVERSIONS";
    const ANALYTICS_METRIC_GROUPS_MOBILE_CONVERSION                 = "MOBILE_CONVERSION";
    const ANALYTICS_METRIC_GROUPS_LIFE_TIME_VALUE_MOBILE_CONVERSION = "LIFE_TIME_VALUE_MOBILE_CONVERSION";


    /**
     * Pulls a list of metrics for the current object instance.
     * @param $metricGroups
     * @param $params
     */
    public function stats($metricGroups, $params)
    {
        //return all_stats($account,$id,)
    }

    public function getId()
    {
        parent::getId();
    }
}