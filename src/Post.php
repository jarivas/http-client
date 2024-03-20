<?php

namespace HttpClient;


class Post
{
    use Client;

    public function __construct(string $url)
    {
        $this->initConnector($url);

        curl_setopt($this->handler, CURLOPT_POST, 1);
    }

    public function sendForm(?string $path = null, ?array $form = null, array $headers = []): array
    {
        $headers[] = 'Content-Type: application/x-www-form-urlencoded';

        curl_setopt($this->handler, CURLOPT_URL, $this->getUrlPath($path));

        if ($form) {
            $query =  http_build_query($form);

            curl_setopt($this->handler, CURLOPT_POSTFIELDS, http_build_query($form));

            $this->log($query);
        }

        return $this->exec($headers);
    }

    public function sendJson(?string $path = null, ?array $body = null, array $headers = []): array
    {
        $headers[] = 'Content-Type: application/json';

        curl_setopt($this->handler, CURLOPT_URL, $this->getUrlPath($path));

        if ($body) {
            $json = json_encode($body);

            curl_setopt($this->handler, CURLOPT_POSTFIELDS, $json);

            $this->log($json);
        }

        return $this->exec($headers, true);
    }
}
