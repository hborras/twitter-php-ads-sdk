<?php

namespace Hborras\TwitterAdsSDK\TwitterAds\Creative;

use Hborras\TwitterAdsSDK\TwitterAds\Fields\VideoWebsiteCardFields;
use Hborras\TwitterAdsSDK\TwitterAds\Resource;

class VideoWebsiteCard extends Resource
{
    const RESOURCE_COLLECTION = 'accounts/{account_id}/cards/video_website';
    const RESOURCE            = 'accounts/{account_id}/cards/video_website/{id}';

    /** Read Only */
    protected $id;
    protected $preview_url;
    protected $created_at;
    protected $updated_at;
    protected $deleted;

    protected $properties = [
        VideoWebsiteCardFields::NAME,
        VideoWebsiteCardFields::WEBSITE_TITLE,
        VideoWebsiteCardFields::WEBSITE_URL,
        VideoWebsiteCardFields::VIDEO_ID,
    ];

    /** Writable */
    protected $name;
    protected $website_title;
    protected $website_url;
    protected $video_id;

    /**
     * @return mixed
     */
    public function getId()
    {
        return $this->id;
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
    public function getWebsiteTitle()
    {
        return $this->website_title;
    }

    /**
     * @param mixed $website_title
     */
    public function setWebsiteTitle($website_title)
    {
        $this->website_title = $website_title;
    }

    /**
     * @return mixed
     */
    public function getWebsiteUrl()
    {
        return $this->website_url;
    }

    /**
     * @param mixed $website_url
     */
    public function setWebsiteUrl($website_url)
    {
        $this->website_url = $website_url;
    }

    /**
     * @return mixed
     */
    public function getVideoId()
    {
        return $this->video_id;
    }

    /**
     * @param mixed $video_id
     */
    public function setVideoId($video_id)
    {
        $this->video_id = $video_id;
    }

    /**
     * @return mixed
     */
    public function getPreviewUrl()
    {
        return $this->preview_url;
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
}
