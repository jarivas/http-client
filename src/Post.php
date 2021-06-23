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

    public function sendForm(?string $path = null, ?array $form = null, ?array $headers = null): array
    {
        curl_setopt($this->handler, CURLOPT_URL, $this->getUrlPath($path));

        if ($form) {
            curl_setopt($this->handler, CURLOPT_POSTFIELDS, http_build_query($form));
        }

        return $this->exec($headers);
    }

    public function sendJson(?string $path = null, ?array $body = null, ?array $headers = null): array
    {
        curl_setopt($this->handler, CURLOPT_URL, $this->getUrlPath($path));

        if ($body) {
            curl_setopt($this->handler, CURLOPT_POSTFIELDS, json_encode($body));
        }

        return $this->exec($headers, true);
    }
}
