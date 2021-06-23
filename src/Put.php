<?php


namespace HttpClient;

/**
 * Class Put
 * @package HttpClient
 */
class Put extends Post
{

    use Client;

    public function __construct(string $url)
    {
        parent::__construct($url);

        curl_setopt($this->handler, CURLOPT_POST, 0);

        curl_setopt($this->handler, CURLOPT_CUSTOMREQUEST, 'PUT');
    }

}