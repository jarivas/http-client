<?php


namespace HttpClient;

/**
 * Class Patch
 * @package HttpClient
 */
class Patch extends Post
{

    use Client;

    public function __construct(string $url)
    {
        parent::__construct($url);

        curl_setopt($this->handler, CURLOPT_POST, 0);

        curl_setopt($this->handler, CURLOPT_CUSTOMREQUEST, 'PATCH');
    }

}