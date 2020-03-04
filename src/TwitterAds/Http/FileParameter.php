<?php

namespace Hborras\TwitterAdsSDK\TwitterAds\Http;

class FileParameter {

  /**
   * @var string
   */
  protected $path;

  /**
   * @var string|null
   */
  protected $mimeType;

  /**
   * @var string|null
   */
  protected $name;

  /**
   * @param string $path
   */
  public function __construct($path) {
    $this->path = $path;
  }

  /**
   * @return string
   */
  public function getPath() {
    return $this->path;
  }

  /**
   * @return null|string
   */
  public function getMimeType() {
    return $this->mimeType;
  }

  /**
   * @param null|string $mime_type
   * @return $this
   */
  public function setMimeType($mime_type) {
    $this->mimeType = $mime_type;
    return $this;
  }

  /**
   * @return null|string
   */
  public function getName() {
    return $this->name;
  }

  /**
   * @param null|string $name
   * @return $this
   */
  public function setName($name) {
    $this->name = $name;
    return $this;
  }
}
