<?php
/**
 * Created by PhpStorm.
 * User: hborras
 * Date: 17/04/16
 * Time: 22:41.
 */
namespace Hborras\TwitterAdsSDK\TwitterAds\Creative;

use Hborras\TwitterAdsSDK\TwitterAds\Fields\VideoFields;
use Hborras\TwitterAdsSDK\TwitterAds\Resource;

class Video extends Resource
{
    const RESOURCE_COLLECTION = 'accounts/{account_id}/videos';
    const RESOURCE = 'accounts/{account_id}/videos/{id}';

    /** Read Only */
    protected $id;
    protected $tweeted;
    protected $ready_to_tweet;
    protected $duration;
    protected $reasons_not_servable;
    protected $preview_url;
    protected $created_at;
    protected $updated_at;
    protected $deleted;

    protected $properties = [
        VideoFields::TITLE,
        VideoFields::DESCRIPTION,
        VideoFields::VIDEO_MEDIA_ID,
    ];

    /** Writable */
    protected $title;
    protected $description;
    protected $video_media_id;

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
    public function getTweeted()
    {
        return $this->tweeted;
    }

    /**
     * @return mixed
     */
    public function getReadyToTweet()
    {
        return $this->ready_to_tweet;
    }

    /**
     * @return mixed
     */
    public function getDuration()
    {
        return $this->duration;
    }

    /**
     * @return mixed
     */
    public function getReasonsNotServable()
    {
        return $this->reasons_not_servable;
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
    public function getDescription()
    {
        return $this->description;
    }

    /**
     * @param mixed $description
     */
    public function setDescription($description)
    {
        $this->description = $description;
    }

    /**
     * @return mixed
     */
    public function getVideoMediaId()
    {
        return $this->video_media_id;
    }

    /**
     * @param mixed $video_media_id
     */
    public function setVideoMediaId($video_media_id)
    {
        $this->video_media_id = $video_media_id;
    }
}
