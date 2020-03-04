<?php

namespace Hborras\TwitterAdsSDK\TwitterAds\Http;

class Parameters extends \ArrayObject {

  /**
   * @param array $data
   */
  public function enhance(array $data) {
    foreach ($data as $key => $value) {
      $this[$key] = $value;
    }
  }

  /**
   * @param mixed $value
   * @return string
   */
  protected function exportNonScalar($value) {
    return json_encode($value);
  }

  /**
   * @return array
   */
  public function export() {
    $data = array();
    foreach ($this as $key => $value) {
      $data[$key] = is_null($value) || is_scalar($value)
        ? $value
        : $this->exportNonScalar($value);
    }

    return $data;
  }
}
