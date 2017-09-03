<?php

namespace Hborras\TwitterAdsSDK\TwitterAds\TailoredAudience;

use Hborras\TwitterAdsSDK\TwitterAds;
use Hborras\TwitterAdsSDK\TwitterAds\Account;
use Hborras\TwitterAdsSDK\TwitterAds\Batch;

/**
 * Represents a Tailored Audience membership batch
 * Supports: POST
 *
 * @since 2016-06-27
 */
final class TailoredAudienceMemberships extends Batch
{
    const MAX_BATCH_SIZE = 100;
    const RESOURCE       = 'tailored_audience_memberships';
    const OPERATION      = 'Update';

    public function __construct(TwitterAds $twitterAds = null, $members = [])
    {
        parent::__construct($twitterAds, self::MAX_BATCH_SIZE, $members);
    }

    /**
     * {@inheritdoc}
     */
    public function save()
    {
        return $this->fromResponse(
            $this->getTwitterAds()->post(self::RESOURCE, [
                'operation_type' => self::OPERATION,
                'params' => $this->toParams(),
            ]));
    }
}
