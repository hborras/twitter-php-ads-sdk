<?php
/**
 * Created by PhpStorm.
 * User: hborras
 * Date: 17/04/16
 * Time: 22:41.
 */
namespace Hborras\TwitterAdsSDK\TwitterAds\Creative;

use Hborras\TwitterAdsSDK\TwitterAds\Fields\ImageAppDownloadCardFields;
use Hborras\TwitterAdsSDK\TwitterAds\Resource;

class ImageAppDownloadCard extends Resource
{
    const RESOURCE_COLLECTION = 'accounts/{account_id}/cards/image_app_download';
    const RESOURCE = 'accounts/{account_id}/cards/image_app_download/{id}';

    /** Read Only */
    protected $id;
    protected $preview_url;
    protected $created_at;
    protected $updated_at;
    protected $deleted;

    protected $properties = [
        ImageAppDownloadCardFields::NAME,
        ImageAppDownloadCardFields::APP_COUNTRY_CODE,
        ImageAppDownloadCardFields::IPHONE_APP_ID,
        ImageAppDownloadCardFields::IPHONE_DEEP_LINK,
        ImageAppDownloadCardFields::IPAD_APP_ID,
        ImageAppDownloadCardFields::IPAD_DEEP_LINK,
        ImageAppDownloadCardFields::GOOGLEPLAY_APP_ID,
        ImageAppDownloadCardFields::GOOGLEPLAY_DEEP_LINK,
        ImageAppDownloadCardFields::APP_CTA,
        ImageAppDownloadCardFields::WIDE_APP_IMAGE_MEDIA_ID
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
    protected $wide_app_image_media_id;

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
    public function getWideAppImageMediaId()
    {
        return $this->wide_app_image_media_id;
    }

    /**
     * @param mixed $wide_app_image_media_id
     */
    public function setWideAppImageMediaId($wide_app_image_media_id)
    {
        $this->wide_app_image_media_id = $wide_app_image_media_id;
    }
}
