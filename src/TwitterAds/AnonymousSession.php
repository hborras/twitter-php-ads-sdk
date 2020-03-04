<?php

namespace Hborras\TwitterAdsSDK\TwitterAds;

class AnonymousSession implements SessionInterface {

  /**
   * @return array
   */
  public function getRequestParameters() {
    return array();
  }
}
