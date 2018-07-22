<?php

namespace Hborras\TwitterAdsSDK;

class TONUpload
{
    const DEFAULT_DOMAIN   = 'https://ton.twitter.com';
    const DEFAULT_RESOURCE = '/1.1/ton/bucket/';
    const DEFAULT_BUCKET   = 'ta_partner';
    const MIN_FILE_SIZE    = 1048576;

    private $filePath;
    private $fileSize;
    /** @var TwitterAds */
    private $twitterAds;
    private $params;

    public function __construct(TwitterAds $twitterAds, $filePath, $params = [])
    {
        if (!file_exists($filePath)) {
            // TODO: Throw Exception
        }
        $this->filePath = $filePath;
        $this->fileSize = filesize($filePath);
        $this->twitterAds = $twitterAds;
        $this->params = $params;
    }

    public function getContentType()
    {
        if (isset($this->contentType)) {
            return $this->contentType;
        }

        $extension = pathinfo($this->filePath, PATHINFO_EXTENSION);

        if ($extension == 'csv') {
            $this->contentType = 'text/csv';
        } elseif ($extension == 'tsv') {
            $this->contentType = 'text/tab-separated-values';
        } else {
            $this->contentType = 'text/plain';
        }

        return $this->contentType;
    }

    public function perform()
    {
        if ($this->fileSize < self::MIN_FILE_SIZE) {
            $response = $this->upload();
            return $response->getsHeaders()['location'];
        } else {
            $response = $this->initChunkedUpload();
            $responseHeaders = $response->getsHeaders();
            $chunkSize = intval($responseHeaders['x_ton_min_chunk_size']);
            $location = $responseHeaders['location'];

            $file = fopen($this->filePath, 'rb');
            $bytesRead = 0;
            while (!feof($file)) {
                $bytes = fread($file, $chunkSize);
                $bytesStart = $bytesRead;
                $bytesRead += strlen($bytes);
                $this->uploadChunk($location, $chunkSize, $bytes, $bytesStart, $bytesRead);
            }
            fclose($file);

            return $location;
        }
    }

    public function upload()
    {
        /** Here you can add any header you want to the request*/
        $headers = [
            'x-ton-expires: ' . gmdate('D, d M Y H:i:s T', strtotime("+10 day")),
            'content-type: ' . $this->getContentType(),
            'Content-Length: ' . $this->fileSize
        ];

        $response = $this->getTwitterAds()->post(self::DEFAULT_DOMAIN . self::DEFAULT_RESOURCE . self::DEFAULT_BUCKET, ['raw' => file_get_contents($this->filePath)], $headers);
        return $response;
    }

    public function uploadChunk($resource, $chunkSize, $bytes, $bytesStart, $bytesRead)
    {
        $headers = [
            'Content-Type: ' . $this->getContentType(),
            'Content-Range: bytes ' . $bytesStart . '-' . ($bytesRead - 1) . '/' . $this->fileSize
        ];
        $response = $this->getTwitterAds()->put(self::DEFAULT_DOMAIN . $resource, ['raw' => $bytes], $headers);

        return $response;
    }

    public function initChunkedUpload()
    {
        $headers = [
            'X-Ton-Content-Type: ' . $this->getContentType(),
            'X-Ton-Content-Length: ' . $this->fileSize,
            'X-Ton-Expires: ' . gmdate('D, d M Y H:i:s T', strtotime("+6 day")),
            'Content-Type: ' . $this->getContentType(),
            'Content-Length: ' . strval(0)
        ];

        $resource = self::DEFAULT_DOMAIN . self::DEFAULT_RESOURCE . self::DEFAULT_BUCKET . '?resumable=true';
        $response = $this->getTwitterAds()->post($resource, [], $headers);
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
