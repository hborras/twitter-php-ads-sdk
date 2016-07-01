<?php

namespace Hborras\TwitterAdsSDK\TwitterAds\TailoredAudience;

use Hborras\TwitterAdsSDK\TwitterAds;
use Hborras\TwitterAdsSDK\Arrayable;

/**
 * Represents a Tailored Audience member
 *
 * @since 2016-06-27
 */
final class TailoredAudienceMember implements Arrayable
{
    const TYPE_TAWEB_PARTNER_USER_ID = 'TAWEB_PARTNER_USER_ID';

    protected $advertiser_account_id;
    protected $user_identifier;
    protected $user_identifier_type = self::TYPE_TAWEB_PARTNER_USER_ID;
    protected $score = 0;
    protected $audience_names = [];
    protected $effective_at;
    protected $expires_at;

    protected $properties = [
        'advertiser_account_id',
        'user_identifier',
        'user_identifier_type',
        'score',
        'audience_names',
        'effective_at',
        'expires_at',
    ];

    /**
     * {@inheritdoc}
     */
    public function getId()
    {
        return null;
    }

    public function getAdvertiserAccountId()
    {
        return $this->advertiser_account_id;
    }

    public function setAdvertiserAccountId($id)
    {
        return $this->advertiser_account_id = $id;
    }

    public function getUserIdentifier()
    {
        return $this->user_identifier;
    }

    public function setUserIdentifier($id)
    {
        return $this->user_identifier = $id;
    }

    public function getUserIdentifierType()
    {
        return $this->user_identifier_type;
    }

    public function setUserIdentifierType($type)
    {
        $this->user_identifier_type = $type;
    }

    public function getScore()
    {
        return $this->score;
    }

    public function setScore(int $score)
    {
        $this->score = $score;
    }

    public function getAudienceNames()
    {
        return implode(', ', $this->audience_names);
    }

    public function setAudienceNames(array $names)
    {
        $this->audience_names =  explode(', ', $names);
    }

    public function getEffectiveAt()
    {
        return $this->effective_at;
    }

    public function setEffectiveAt(\DateTimeInterface $date)
    {
        $this->effective_at = $date;
    }

    public function getExpiresAt()
    {
        return $this->expires_at;
    }

    public function setExpiresAt(\DateTimeInterface $date)
    {
        $this->expires_at = $date;
    }

    public function toArray()
    {
        return [
            'advertiser_account_id' => $this->getAdvertiserAccountId(),
            'user_identifier'       => $this->getUserIdentifier(),
            'user_identifier_type'  => $this->getUserIdentifierType(),
            'score'                 => $this->getScore(),
            'audience_names'        => $this->getAudienceNames(),
            'effective_at'          => $this->getEffectiveAt(),
            'expires_at'            => $this->getExpiresAt(),
        ];
    }

    /**
     * @return array
     */
    public function getProperties()
    {
        return $this->properties;
    }
}
