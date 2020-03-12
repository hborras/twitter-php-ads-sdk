<?php

namespace Hborras\TwitterAdsSDK\TwitterAds\Http;

use DateTimeInterface;

class Parameters extends \ArrayObject
{

    /**
     * @param array $data
     */
    public function enhance(array $data)
    {
        foreach ($data as $key => $value) {
            $this[$key] = $value;
        }
    }

    /**
     * @param mixed $value
     * @return string
     */
    protected function exportNonScalar($value)
    {
        return implode(',', $value);
    }

    /**
     * @return array
     */
    public function export()
    {
        $data = array();
        foreach ($this as $key => $value) {
            if (is_bool($value)) {
                if ($value) {
                    $value = 'true';
                } else {
                    $value = 'false';
                }
            }
            if($value instanceof DateTimeInterface){
                $value = $value->format('c');
            }
            $data[$key] = is_null($value) || is_scalar($value)
                ? $value
                : $this->exportNonScalar($value);
        }

        return $data;
    }
}
