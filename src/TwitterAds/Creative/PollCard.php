<?php

namespace Hborras\TwitterAdsSDK\TwitterAds\Creative;

use Hborras\TwitterAdsSDK\TwitterAds\Fields\PollCardFields;
use Hborras\TwitterAdsSDK\TwitterAds\Resource;

class PollCard extends Resource
{
    const RESOURCE_COLLECTION = 'accounts/{account_id}/cards/poll';
    const RESOURCE            = 'accounts/{account_id}/cards/poll/{id}';

    /** Read Only */
    protected $id;
    protected $preview_url;
    protected $created_at;
    protected $updated_at;
    protected $deleted;

    protected $properties = [
        PollCardFields::NAME,
        PollCardFields::DURATION_IN_MINUTES,
        PollCardFields::FIRST_CHOICE,
        PollCardFields::SECOND_CHOICE,
    ];

    /** Writable */
    protected $name;
    protected $duration_in_minutes;
    protected $first_choice;
    protected $second_choice;
    protected $third_choice;
    protected $fourth_choice;
    protected $media_key;

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
    public function getDurationInMinutes()
    {
        return $this->duration_in_minitues;
    }

    /**
     * @param mixed $duration_in_minitues
     */
    public function setDurationInMinutes($duration_in_minutes)
    {
        $this->duration_in_minutes = $duration_in_minutes;
    }

    /**
     * @return mixed
     */
    public function getMediaKey()
    {
        return $this->media_key;
    }

    /**
     * @param mixed $media_key
     */
    public function setMediaKey($media_key)
    {
        $this->media_key = $media_key;
    }

    /**
     * @return mixed
     */
    public function getFirstChoice()
    {
        return $this->first_choice;
    }

    /**
     * @param mixed $first_choice
     */
    public function setFirstChoice($first_choice)
    {
        $this->first_choice = $first_choice;
    }

    /**
     * @return mixed
     */
    public function getSecondChoice()
    {
        return $this->second_choice;
    }

    /**
     * @param mixed $second_choice
     */
    public function setSecondChoice($second_choice)
    {
        $this->second_choice = $second_choice;
    }

    /**
     * @param array $choices
     */
    public function setChoices(array $choices)
    {
        if (count($choices) == 0) {
            return;
        }
        $this->first_choice = $choices[0];
        if (count($choices) == 1) {
            return;
        }
        $this->second_choice = $choices[1];
        if (count($choices) == 2) {
            return;
        }
        $this->third_choice = $choices[2];
        if (count($choices) == 3) {
            return;
        }
        $this->fourth_choice = $choices[3];
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

    public function toParams()
    {
        $params = parent::toParams();
        if (isset($this->third_choice)) {
            $params[PollCardFields::THIRD_CHOICE] = $this->third_choice;
        }
        if (isset($this->fourth_choice)) {
            $params[PollCardFields::FOURTH_CHOICE] = $this->fourth_choice;
        }
        if (isset($this->media_key)) {
            $params[PollCardFields::MEDIA_KEY] = $this->media_key;
        }
        return $params;
    }
}
