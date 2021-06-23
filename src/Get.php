<?php

namespace HttpClient;


class Get
{
    use Client;

    /**
     * Get constructor.
     * @param string $url
     */
    public function __construct(string $url)
    {
        $this->initConnector($url);

        curl_setopt($this->handler, CURLOPT_HEADER, 0);
    }

    /**
     * @param array|null $params
     * @param array|null $headers
     * @param bool $jsonResponse default false
     * @return array [success, result]
     */
    public function send(?array $params = null, ?array $headers = null, bool $jsonResponse = false): array
    {
        curl_setopt($this->handler, CURLOPT_URL, $this->getUrlParams($params));

        return self::exec($headers, $jsonResponse);
    }
}
