<?php
/**
 * Created by PhpStorm.
 * User: hborras
 * Date: 23/04/16
 * Time: 10:47
 */

namespace Hborras\TwitterAdsSDK\TwitterAds;


use Hborras\TwitterAdsSDK\TwitterAds\Analytics\Job;
use Hborras\TwitterAdsSDK\TwitterAds\Errors\BadRequest;
use Hborras\TwitterAdsSDK\TwitterAds\Fields\AnalyticsFields;

class Analytics extends Resource
{
    const ENTITY              = "";
    const RESOURCE_STATS      = 'stats/accounts/{account_id}/';
    const RESOURCE_STATS_JOBS = 'stats/jobs/accounts/{account_id}/';

    /**
     * Pulls a list of metrics for the current object instance.
     * @param $metricGroups
     * @param array $params
     * @param bool $async
     * @return $this
     * @throws BadRequest
     */
    public function stats($metricGroups, $params = [], $async = false)
    {
        return $this->all_stats([$this->getId()], $metricGroups, $params, $async);
    }


    public function all_stats($ids, $metricGroups, $params = [], $async = false)
    {
        $endTime = isset($params[AnalyticsFields::END_TIME]) ? $params[AnalyticsFields::END_TIME] : new \DateTime('now');
        $endTime->setTime($endTime->format('H'), 0, 0);
        $startTime = isset($params[AnalyticsFields::START_TIME]) ? $params[AnalyticsFields::START_TIME] : new \DateTime($endTime->format('c') . " - 7 days");
        $startTime->setTime($startTime->format('H'), 0, 0);
        $granularity = isset($params[AnalyticsFields::GRANULARITY]) ? $params[AnalyticsFields::GRANULARITY] : Enumerations::GRANULARITY_TOTAL;
        $placement = isset($params[AnalyticsFields::PLACEMENT]) ? $params[AnalyticsFields::PLACEMENT] : Enumerations::PLACEMENT_ALL_ON_TWITTER;
        if (isset($params[AnalyticsFields::ENTITY])) {
            $entity = $params[AnalyticsFields::ENTITY];
        } else {
            throw new BadRequest('Entity parameter is mandatory', 500, []);
        }
        if (!self::inAvailableEntities($entity)) {
            throw new BadRequest('Entity must be one of ACCOUNT,FUNDING_INSTRUMENT,CAMPAIGN,LINE_ITEM,PROMOTED_TWEET,ORGANIC_TWEET', 500, []);
        }
        $segmentationType = isset($params[AnalyticsFields::SEGMENTATION_TYPE]) ? $params[AnalyticsFields::SEGMENTATION_TYPE] : null;

        $params = [
            AnalyticsFields::METRIC_GROUPS => implode(",", $metricGroups),
            AnalyticsFields::START_TIME => $startTime->format('c'),
            AnalyticsFields::END_TIME => $endTime->format('c'),
            AnalyticsFields::GRANULARITY => $granularity,
            AnalyticsFields::ENTITY => $entity,
            AnalyticsFields::ENTITY_IDS => implode(",", $ids),
            AnalyticsFields::PLACEMENT => $placement,
        ];

        if (!$async) {
            $resource = str_replace(static::RESOURCE_REPLACE, $this->getTwitterAds()->getAccountId(), static::RESOURCE_STATS);
            $response = $this->getTwitterAds()->get($resource, $params);

            return $response->getBody()->data;
        } else {
            if (!is_null($segmentationType)) {
                $params[AnalyticsFields::SEGMENTATION_TYPE] = $segmentationType;
            }

            $resource = str_replace(static::RESOURCE_REPLACE, $this->getTwitterAds()->getAccountId(), static::RESOURCE_STATS_JOBS);
            $response = $this->getTwitterAds()->post($resource, $params);
            $job = new Job();
            return $job->fromResponse($response->getBody()->data);
        }
    }

    public static function inAvailableEntities($entity)
    {
        $availableEntities = [
            AnalyticsFields::ACCOUNT,
            AnalyticsFields::FUNDING_INSTRUMENT,
            AnalyticsFields::CAMPAIGN,
            AnalyticsFields::LINE_ITEM,
            AnalyticsFields::PROMOTED_TWEET,
            AnalyticsFields::ORGANIC_TWEET,
        ];

        return in_array($entity, $availableEntities);
    }

    public function getId()
    {
        return parent::getId();
    }
}