<?php


namespace HttpClient;


class Delete extends Get
{
    public function __construct(string $url)
    {
        parent::__construct($url);

        curl_setopt($this->handler, CURLOPT_CUSTOMREQUEST, 'DELETE');
    }
}