<?php

namespace JmaDsm\GatewayClient;

class Client {
    // Hold the class instance.
    private static $instance;
    private $curl, $serviceName, $baseUrl, $accessToken, $tenantToken;

    // The object is created from within the class itself
    // only if the class has no instance.
    public static function getInstance($baseUrl = null, $accessToken = null, $tenantToken = null)
    {
        if (self::$instance == null)
        {
            self::$instance = new self($baseUrl, $accessToken, $tenantToken);
        }

        return self::$instance;
    }

    private function __construct ($baseUrl = null, $accessToken = null, $tenantToken = null)
    {
        if($baseUrl) $this->setBaseUrl($baseUrl);
        if($accessToken) $this->setAccessToken($accessToken);
        if($tenantToken) $this->setTenantToken($tenantToken);

        $this->curl = curl_init();

        curl_setopt($this->curl, CURLOPT_FOLLOWLOCATION, true);
        curl_setopt($this->curl, CURLOPT_RETURNTRANSFER, true);
    }

    public function setBaseUrl($baseUrl)
    {
        $this->baseUrl = $baseUrl;
    }

    public function getBaseUrl()
    {
        return $this->baseUrl;
    }

    public function setAccessToken($accessToken = null)
    {
        $this->accessToken = $accessToken;
    }

    public function getAccessToken()
    {
        return $this->accessToken;
    }

    public function setTenantToken($tenantToken = null)
    {
        $this->tenantToken = $tenantToken;
    }

    public function getTenantToken()
    {
        return $this->tenantToken;
    }

    public function service($serviceName = null)
    {
        if ($serviceName) $this->serviceName = $serviceName;
        return $this;
    }

    public function request($method, $url = '/', $payload = null)
    {
        $this->setApiClientHeaders();

        $url = rtrim($this->baseUrl, '/') . '/' . $this->serviceName . rtrim('/' . ltrim(strval($url), '/'), '/');

        switch (strtoupper($method)) {
            case 'GET':
            case 'DELETE':
                $url = $payload ? $url . '?' . http_build_query($payload) : $url;
                break;
            case 'POST':
                curl_setopt($this->curl, CURLOPT_POST, true);
                curl_setopt($this->curl, CURLOPT_POSTFIELDS, $payload);
                break;
            default:
                throw \Exception('Undefined HTTP method', 1);
        }

        curl_setopt($this->curl, CURLOPT_URL, $url);
        $response = curl_exec($this->curl);

        // Exception handling
        $httpCode = curl_getinfo($this->curl, CURLINFO_HTTP_CODE);

        if (substr(strval($httpCode), 0, 1) !== "2" && $httpCode !== 404)
        {
            throw \Exception('Unhandled HTTP code from response: ' . $httpCode, 1);
        }

        return $response;
    }

    private function setApiClientHeaders() {
        curl_setopt($this->curl, CURLOPT_HTTPHEADER, array(
            'Authorization: Bearer ' . $this->accessToken,
            'x-tenant-token: ' . $this->tenantToken,
        ));
    }

    public function get($url = '', $payload = null)
    {
        return $this->request('GET', $url, $payload);
    }

    public function post($url, $payload = null)
    {
        return $this->request('POST', $url, $payload);
    }
}
