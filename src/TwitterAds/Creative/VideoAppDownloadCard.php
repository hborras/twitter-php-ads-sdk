<?php

namespace Hborras\TwitterAdsSDK\TwitterAds\Creative;

use Hborras\TwitterAdsSDK\TwitterAds\Fields\VideoAppDownloadCardFields;
use Hborras\TwitterAdsSDK\TwitterAds\Resource;

class VideoAppDownloadCard extends Resource
{
    const RESOURCE_COLLECTION = 'accounts/{account_id}/cards/video_app_download';
    const RESOURCE            = 'accounts/{account_id}/cards/video_app_download/{id}';

    /** Read Only */
    protected $id;
    protected $preview_url;
    protected $video_url;
    protected $video_poster_url;
    protected $created_at;
    protected $updated_at;
    protected $deleted;

    protected $properties = [
        VideoAppDownloadCardFields::NAME,
        VideoAppDownloadCardFields::APP_COUNTRY_CODE,
        VideoAppDownloadCardFields::IPHONE_APP_ID,
        VideoAppDownloadCardFields::IPAD_DEEP_LINK,
        VideoAppDownloadCardFields::IPAD_APP_ID,
        VideoAppDownloadCardFields::IPAD_DEEP_LINK,
        VideoAppDownloadCardFields::GOOGLEPLAY_APP_ID,
        VideoAppDownloadCardFields::GOOGLEPLAY_DEEP_LINK,
        VideoAppDownloadCardFields::APP_CTA,
        VideoAppDownloadCardFields::IMAGE_MEDIA_ID,
        VideoAppDownloadCardFields::VIDEO_ID,
    ];

    /** Writable */
    protected $name;
    protected $app_country_code;
    protected $iphone_app_id;
    protected $iphone_deep_link;
    protected $ipad_app_id;
    protected $ipad_deep_link;
    protected $googleplay_app_id;
    protected $googleplay_deep_link;
    protected $app_cta;
    protected $image_media_id;
    protected $video_id;

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
    public function getAppCountryCode()
    {
        return $this->app_country_code;
    }

    /**
     * @param mixed $app_country_code
     */
    public function setAppCountryCode($app_country_code)
    {
        $this->app_country_code = $app_country_code;
    }

    /**
     * @return mixed
     */
    public function getIphoneAppId()
    {
        return $this->iphone_app_id;
    }

    /**
     * @param mixed $iphone_app_id
     */
    public function setIphoneAppId($iphone_app_id)
    {
        $this->iphone_app_id = $iphone_app_id;
    }

    /**
     * @return mixed
     */
    public function getIphoneDeepLink()
    {
        return $this->iphone_deep_link;
    }

    /**
     * @param mixed $iphone_deep_link
     */
    public function setIphoneDeepLink($iphone_deep_link)
    {
        $this->iphone_deep_link = $iphone_deep_link;
    }

    /**
     * @return mixed
     */
    public function getIpadAppId()
    {
        return $this->ipad_app_id;
    }

    /**
     * @param mixed $ipad_app_id
     */
    public function setIpadAppId($ipad_app_id)
    {
        $this->ipad_app_id = $ipad_app_id;
    }

    /**
     * @return mixed
     */
    public function getIpadDeepLink()
    {
        return $this->ipad_deep_link;
    }

    /**
     * @param mixed $ipad_deep_link
     */
    public function setIpadDeepLink($ipad_deep_link)
    {
        $this->ipad_deep_link = $ipad_deep_link;
    }

    /**
     * @return mixed
     */
    public function getGoogleplayAppId()
    {
        return $this->googleplay_app_id;
    }

    /**
     * @param mixed $googleplay_app_id
     */
    public function setGoogleplayAppId($googleplay_app_id)
    {
        $this->googleplay_app_id = $googleplay_app_id;
    }

    /**
     * @return mixed
     */
    public function getGoogleplayDeepLink()
    {
        return $this->googleplay_deep_link;
    }

    /**
     * @param mixed $googleplay_deep_link
     */
    public function setGoogleplayDeepLink($googleplay_deep_link)
    {
        $this->googleplay_deep_link = $googleplay_deep_link;
    }

    /**
     * @return mixed
     */
    public function getAppCta()
    {
        return $this->app_cta;
    }

    /**
     * @param mixed $app_cta
     */
    public function setAppCta($app_cta)
    {
        $this->app_cta = $app_cta;
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
    public function getVideoUrl()
    {
        return $this->video_url;
    }

    /**
     * @return mixed
     */
    public function getVideoPosterUrl()
    {
        return $this->video_poster_url;
    }
}
