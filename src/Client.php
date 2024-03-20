<?php

namespace HttpClient;

use Psr\Log\LoggerInterface;
use CurlHandle;
use resource;

trait Client
{
    protected bool|CurlHandle|resource $handler;
    protected string $url;
    protected string $instanceId;
    protected LoggerInterface $logger;

    public function initConnector(string $url, LoggerInterface|null $logger = null)
    {
        $this->handler = curl_init();
        $this->url = $url;
        $this->instanceId = uniqid();
        $this->logger = (is_null($logger)) ? new Logger() : $logger;
        
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
        
            $this->log($headers);
        }

        $response = curl_exec($this->handler);

        $this->log($response);

        if (curl_errno($this->handler)) {
            return self::error(curl_error($this->handler));
        }

        return ($jsonResponse) ? self::parseJson($response) : self::success($response);
    }

    protected function log(string|array $message): void
    {
        if (is_array($message)) {
            $message = json_encode($message);
        }

        $this->logger->info("{$this->instanceId} :: {$message}");
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
        if (empty($response)) {
            return [];
        }

        $json = json_decode($response, true);

        if (!$json || empty($json)) {
            return self::error('Problem parsing response');
        }

        return ['success' => true, 'result' => $json];
    }

    protected function getUrlParams(?string $path = null, ?array $params = null): string
    {
        $result = $this->url;

        if ($path) {
            $result .= $path;
        }

        if ($params) {
            $result .= '?' . http_build_query($params);
        }

        $this->log($result);

        return $result;
    }

    protected function getUrlPath(?string $path = null): string
    {
        $result = $this->url;

        if ($path) {
            $result .= $path;
        }

        $this->log($result);

        return $result;
    }
}
