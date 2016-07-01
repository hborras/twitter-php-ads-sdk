<?php
/**
 * Created by PhpStorm.
 * User: hborras
 * Date: 1/07/16
 * Time: 21:35
 */

namespace Hborras\TwitterAdsSDK;


class TONUpload
{
    const DEFAULT_DOMAIN = 'https://ton.twitter.com';
    const DEFAULT_RESOURCE = '/1.1/ton/bucket/';
    const DEFAULT_BUCKET = 'ta_partner';
    const MIN_FILE_SIZE = 1048576;

    private $filePath;
    private $fileSize;
    private $twitterAds;
    private $params;
    public $defaultExpire;

    public function __construct(TwitterAds $twitterAds, $filePath, $params = [])
    {
        if (! file_exists($filePath)){
            // TODO: Throw Exception
        }
        $defaultExpire = date_create()->modify("+10 day");
        $this->filePath = $filePath;
        $this->fileSize = filesize($filePath);
        $this->twitterAds = $twitterAds;
        $this->params = $params;
    }

    public function getContentType()
    {
        if(isset($this->contentType)){
            return $this->contentType;
        }

        $extension = pathinfo($this->filePath, PATHINFO_EXTENSION);

        if($extension == 'csv'){
            $this->contentType = 'text/csv';
        } else if($extension == 'tsv') {
            $this->contentType = 'text/tab-separated-values';
        } else {
            $this->contentType = 'text/plain';
        }

        return $this->contentType;
    }

    public function perform()
    {
        if($this->fileSize < self::MIN_FILE_SIZE){

        } else {
            
        }
    }

    /**
     * @return mixed
     */
    public function getFilePath()
    {
        return $this->filePath;
    }

    /**
     * @param mixed $filePath
     */
    public function setFilePath($filePath)
    {
        $this->filePath = $filePath;
    }

    /**
     * @return mixed
     */
    public function getFileSize()
    {
        return $this->fileSize;
    }

    /**
     * @param mixed $fileSize
     */
    public function setFileSize($fileSize)
    {
        $this->fileSize = $fileSize;
    }

    /**
     * @return mixed
     */
    public function getTwitterAds()
    {
        return $this->twitterAds;
    }

    /**
     * @param mixed $twitterAds
     */
    public function setTwitterAds($twitterAds)
    {
        $this->twitterAds = $twitterAds;
    }

    /**
     * @return mixed
     */
    public function getParams()
    {
        return $this->params;
    }

    /**
     * @param mixed $params
     */
    public function setParams($params)
    {
        $this->params = $params;
    }

    /**
     * @return mixed
     */
    public function getBucket()
    {
        return $this->bucket;
    }

    /**
     * @param mixed $bucket
     */
    public function setBucket($bucket)
    {
        $this->bucket = $bucket;
    }
}