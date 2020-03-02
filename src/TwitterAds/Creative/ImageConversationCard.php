<?php

namespace Hborras\TwitterAdsSDK\TwitterAds\Creative;

use Hborras\TwitterAdsSDK\TwitterAds\Fields\ImageConversationCardFields;
use Hborras\TwitterAdsSDK\TwitterAds\Resource;

class ImageConversationCard extends Resource
{
    const RESOURCE_COLLECTION = 'accounts/{account_id}/cards/image_conversation';
    const RESOURCE            = 'accounts/{account_id}/cards/image_conversation/{id}';

    /** Read Only */
    protected $id;
    protected $created_at;
    protected $updated_at;
    protected $deleted;

    protected $properties = [
        ImageConversationCardFields::NAME,
        ImageConversationCardFields::TITLE,
        ImageConversationCardFields::FIRST_CTA,
        ImageConversationCardFields::FIRST_CTA_TWEET,
        ImageConversationCardFields::SECOND_CTA,
        ImageConversationCardFields::SECOND_CTA_TWEET,
        ImageConversationCardFields::THANK_YOU_TEXT,
        ImageConversationCardFields::THANK_YOU_URL,
        ImageConversationCardFields::IMAGE_MEDIA_ID,
    ];

    /** Writable */
    protected $name;
    protected $title;
    protected $first_cta;
    protected $first_cta_tweet;
    protected $second_cta;
    protected $second_cta_tweet;
    protected $thank_you_text;
    protected $thank_you_url;
    protected $image_media_id;

    /**
     * @return mixed
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @return mixed
     */
    public function getCreatedAt()
    {
        return $this->created_at;
    }

    /**
     * @return mixed
     */
    public function getUpdatedAt()
    {
        return $this->updated_at;
    }

    /**
     * @return mixed
     */
    public function getDeleted()
    {
        return $this->deleted;
    }

    /**
     * @return array
     */
    public function getProperties()
    {
        return $this->properties;
    }

    /**
     * @param array $properties
     */
    public function setProperties($properties)
    {
        $this->properties = $properties;
    }

    /**
     * @return mixed
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * @param mixed $name
     */
    public function setName($name)
    {
        $this->name = $name;
    }

    /**
     * @return mixed
     */
    public function getTitle()
    {
        return $this->title;
    }

    /**
     * @param mixed $title
     */
    public function setTitle($title)
    {
        $this->title = $title;
    }

    /**
     * @return mixed
     */
    public function getFirstCta()
    {
        return $this->first_cta;
    }

    /**
     * @param mixed $first_cta
     */
    public function setFirstCta($first_cta)
    {
        $this->first_cta = $first_cta;
    }

    /**
     * @return mixed
     */
    public function getFirstCtaTweet()
    {
        return $this->first_cta_tweet;
    }

    /**
     * @param mixed $first_cta_tweet
     */
    public function setFirstCtaTweet($first_cta_tweet)
    {
        $this->first_cta_tweet = $first_cta_tweet;
    }

    /**
     * @return mixed
     */
    public function getSecondCta()
    {
        return $this->second_cta;
    }

    /**
     * @param mixed $second_cta
     */
    public function setSecondCta($second_cta)
    {
        $this->second_cta = $second_cta;
    }

    /**
     * @return mixed
     */
    public function getSecondCtaTweet()
    {
        return $this->second_cta_tweet;
    }

    /**
     * @param mixed $second_cta_tweet
     */
    public function setSecondCtaTweet($second_cta_tweet)
    {
        $this->second_cta_tweet = $second_cta_tweet;
    }

    /**
     * @return mixed
     */
    public function getThankYouText()
    {
        return $this->thank_you_text;
    }

    /**
     * @param mixed $thank_you_text
     */
    public function setThankYouText($thank_you_text)
    {
        $this->thank_you_text = $thank_you_text;
    }

    /**
     * @return mixed
     */
    public function getThankYouUrl()
    {
        return $this->thank_you_url;
    }

    /**
     * @param mixed $thank_you_url
     */
    public function setThankYouUrl($thank_you_url)
    {
        $this->thank_you_url = $thank_you_url;
    }

    /**
     * @return mixed
     */
    public function getImageMediaId()
    {
        return $this->image_media_id;
    }

    /**
     * @param mixed $image_media_id
     */
    public function setImageMediaId($image_media_id)
    {
        $this->image_media_id = $image_media_id;
    }
}
