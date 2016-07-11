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
    const DEFAULT_DOMAIN = 'https://ton.twitter.com/1.1/ton/bucket/ta_partner';
    const DEFAULT_RESOURCE = '/1.1/ton/bucket/';
    const DEFAULT_BUCKET = 'ta_partner';
    const MIN_FILE_SIZE = 1048576;

    private $filePath;
    private $fileSize;
    /** @var TwitterAds  */
    private $twitterAds;
    private $params;

    public function __construct(TwitterAds $twitterAds, $filePath, $params = [])
    {
        if (! file_exists($filePath)){
            // TODO: Throw Exception
        }
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
            $response = $this->upload();
        } else {
            
        }
    }

    public function upload()
    {
        /** Here you can add any header you want to the request*/
        $headers = [
            'x-ton-expires: '.gmdate('D, d M Y H:i:s T', strtotime("+10 day")),
            'content-type: '.$this->getContentType(),
            'Content-Length: '. $this->fileSize
        ];

        $response = $this->getTwitterAds()->post(self::DEFAULT_DOMAIN, ['raw'=>file_get_contents($this->filePath)], $headers);

        return $response;
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
     * @return TwitterAds
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
}