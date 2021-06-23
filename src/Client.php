<?php

namespace HttpClient;


trait Client
{
    protected $handler;
    protected $url;

    public function initConnector(string $url)
    {
        $this->handler = curl_init();
        $this->url = $url;
        
        curl_setopt($this->handler, CURLOPT_RETURNTRANSFER, true);
    }

    public function __destruct()
    {
        curl_close($this->handler);
    }

    protected function exec(?array $headers = null, bool $jsonResponse = false): array
    {
        if ($headers) {
            curl_setopt($this->handler, CURLOPT_HTTPHEADER, $headers);
        }

        $response = curl_exec($this->handler);

        if (curl_errno($this->handler)) {
            return self::error(curl_error($this->handler));
        }

        return ($jsonResponse) ? self::parseJson($response) : self::success($response);
    }

    protected static function success(string $response): array
    {
        return ['success' => true, 'result' => $response];
    }

    protected static function error(string $error): array
    {
        return ['success' => false, 'result' => $error];
    }

    protected static function parseJson(string $response): array
    {
        if (!strlen($response)) {
            return self::error('Empty response');
        }

        $json = json_decode($response, true);

        if (!$json || empty($json)) {
            return self::error('Problem parsing response');
        }

        return ['success' => true, 'result' => $json];
    }

    protected function getUrlParams(?array $params = null): string
    {
        $result = $this->url;

        if ($params) {
            $result .= '?' . http_build_query($params);
        }

        return $result;
    }

    protected function getUrlPath(?string $path = null): string
    {
        $result = $this->url;

        if ($path) {
            $result .= $path;
        }

        return $result;
    }
}
