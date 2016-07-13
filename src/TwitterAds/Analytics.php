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
    const ANALYTICS_METRIC_GROUPS_ENGAGEMENT                        = "ENGAGEMENT";
    const ANALYTICS_METRIC_GROUPS_BILLING                           = "BILLING";
    const ANALYTICS_METRIC_GROUPS_VIDEO                             = "VIDEO";
    const ANALYTICS_METRIC_GROUPS_MEDIA                             = "MEDIA";
    const ANALYTICS_METRIC_GROUPS_WEB_CONVERSIONS                   = "WEB_CONVERSIONS";
    const ANALYTICS_METRIC_GROUPS_MOBILE_CONVERSION                 = "MOBILE_CONVERSION";
    const ANALYTICS_METRIC_GROUPS_LIFE_TIME_VALUE_MOBILE_CONVERSION = "LIFE_TIME_VALUE_MOBILE_CONVERSION";
    const ENTITY                                                    = "";
    const RESOURCE_STATS                                            = 'stats/accounts/{account_id}/';

    /**
     * Pulls a list of metrics for the current object instance.
     * @param $metricGroups
     * @param $params
     */
    public function stats($metricGroups, $params = [])
    {
        return $this->all_stats($this->getAccount(), [$this->getId()], $metricGroups, $params);
    }


    public static function all_stats(Account $account, $ids, $metricGroups, $params = [])
    {
        $endTime = isset($params['end_time']) ? $params['end_time'] : new \DateTime('now');
        $endTime->setTime($endTime->format('H'), 0, 0);
        $startTime = isset($params['start_time']) ? $params['start_time'] : new \DateTime($endTime->format('c')." - 7 days");
        $startTime->setTime($startTime->format('H'), 0, 0);
        $granularity = isset($params['granularity']) ? $params['granularity'] : Enumerations::GRANULARITY_HOUR;
        $placement = isset($params['placement']) ? $params['placement'] : Enumerations::PLACEMENT_ALL_ON_TWITTER;
        $segmentationType = isset($params['segmentation_type']) ? $params['segmentation_type'] : null;

        $params = [
            'metric_groups' => implode(",", $metricGroups),
            'start_time' => $startTime->format('c'),
            'end_time' => $endTime->format('c'),
            'granularity' => $granularity,
            'entity' => static::ENTITY,
            'entity_ids' => implode(",", $ids),
            'placement' => $placement,
        ];

        if (!is_null($segmentationType)) {
            $params['segmentation_type'] = $segmentationType;
        }

        $resource = str_replace(static::RESOURCE_REPLACE, $account->getId(), static::RESOURCE_STATS);
        $response = $account->getTwitterAds()->get($resource, $params);

        return $response->getBody()->data;
    }

    public function getId()
    {
        return parent::getId();
    }
}