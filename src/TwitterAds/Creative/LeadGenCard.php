<?php
/**
 * Created by PhpStorm.
 * User: hborras
 * Date: 17/04/16
 * Time: 22:41.
 */
namespace Hborras\TwitterAdsSDK\TwitterAds\Creative;

use Hborras\TwitterAdsSDK\TwitterAds\Resource;

class LeadGenCard extends Resource
{
    const RESOURCE_COLLECTION = 'accounts/{account_id}/cards/lead_gen';
    const RESOURCE = 'accounts/{account_id}/cards/lead_gen/{id}';

    /** Read Only */
    protected $id;
    protected $preview_url;
    protected $created_at;
    protected $updated_at;
    protected $deleted;

    protected $properties = [
        'name',
        'image_media_id',
        'cta',
        'fallback_url',
        'privacy_policy_url',
        'title',
        'submit_url',
        'submit_method',
        'custom_destination_url',
        'custom_destination_text',
        'custom_key_screen_name',
        'custom_key_name',
        'custom_key_email',
    ];

    /** Writable */
    protected $name;
    protected $image_media_id;
    protected $cta;
    protected $fallback_url;
    protected $privacy_policy_url;
    protected $title;
    protected $submit_url;
    protected $submit_method;
    protected $custom_destination_url;
    protected $custom_destination_text;
    protected $custom_key_screen_name;
    protected $custom_key_name;
    protected $custom_key_email;

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
    public function getCta()
    {
        return $this->cta;
    }

    /**
     * @param mixed $cta
     */
    public function setCta($cta)
    {
        $this->cta = $cta;
    }

    /**
     * @return mixed
     */
    public function getFallbackUrl()
    {
        return $this->fallback_url;
    }

    /**
     * @param mixed $fallback_url
     */
    public function setFallbackUrl($fallback_url)
    {
        $this->fallback_url = $fallback_url;
    }

    /**
     * @return mixed
     */
    public function getPrivacyPolicyUrl()
    {
        return $this->privacy_policy_url;
    }

    /**
     * @param mixed $privacy_policy_url
     */
    public function setPrivacyPolicyUrl($privacy_policy_url)
    {
        $this->privacy_policy_url = $privacy_policy_url;
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
    public function getSubmitUrl()
    {
        return $this->submit_url;
    }

    /**
     * @param mixed $submit_url
     */
    public function setSubmitUrl($submit_url)
    {
        $this->submit_url = $submit_url;
    }

    /**
     * @return mixed
     */
    public function getSubmitMethod()
    {
        return $this->submit_method;
    }

    /**
     * @param mixed $submit_method
     */
    public function setSubmitMethod($submit_method)
    {
        $this->submit_method = $submit_method;
    }

    /**
     * @return mixed
     */
    public function getCustomDestinationUrl()
    {
        return $this->custom_destination_url;
    }

    /**
     * @param mixed $custom_destination_url
     */
    public function setCustomDestinationUrl($custom_destination_url)
    {
        $this->custom_destination_url = $custom_destination_url;
    }

    /**
     * @return mixed
     */
    public function getCustomDestinationText()
    {
        return $this->custom_destination_text;
    }

    /**
     * @param mixed $custom_destination_text
     */
    public function setCustomDestinationText($custom_destination_text)
    {
        $this->custom_destination_text = $custom_destination_text;
    }

    /**
     * @return mixed
     */
    public function getCustomKeyScreenName()
    {
        return $this->custom_key_screen_name;
    }

    /**
     * @param mixed $custom_key_screen_name
     */
    public function setCustomKeyScreenName($custom_key_screen_name)
    {
        $this->custom_key_screen_name = $custom_key_screen_name;
    }

    /**
     * @return mixed
     */
    public function getCustomKeyName()
    {
        return $this->custom_key_name;
    }

    /**
     * @param mixed $custom_key_name
     */
    public function setCustomKeyName($custom_key_name)
    {
        $this->custom_key_name = $custom_key_name;
    }

    /**
     * @return mixed
     */
    public function getCustomKeyEmail()
    {
        return $this->custom_key_email;
    }

    /**
     * @param mixed $custom_key_email
     */
    public function setCustomKeyEmail($custom_key_email)
    {
        $this->custom_key_email = $custom_key_email;
    }
}
