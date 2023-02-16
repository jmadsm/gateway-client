<?php

namespace JmaDsm\GatewayClient;

class Client
{
    /**
     * Class instance for singleton usage
     *
     * @var Client
     */
    private static $instance;

    private $accessToken, $baseUrl, $curl, $tenantToken, $apiPath;

    /**
     * Gets the active class instance from $instance. If instance is not set
     * Create a new class instance and save it in $instance
     *
     * @param string $baseUrl
     * @param string $accessToken
     * @param string $tenantToken
     * @return Client
     */
    public static function getInstance($baseUrl = null, $accessToken = null, $tenantToken = null, $apiPath = null)
    {
        if (!self::$instance) {
            self::$instance = new self($baseUrl, $accessToken, $tenantToken, $apiPath);
        }

        return self::$instance;
    }

    /**
     * Creates curl based http client
     *
     * @param string $baseUrl
     * @param string $accessToken
     * @param string $tenantToken
     */
    private function __construct($baseUrl = null, $accessToken = null, $tenantToken = null, $apiPath = null)
    {
        if ($baseUrl) $this->setBaseUrl($baseUrl);
        if ($accessToken) $this->setAccessToken($accessToken);
        if ($tenantToken) $this->setTenantToken($tenantToken);
        if ($apiPath) $this->setApiPath($apiPath);

        $this->curl = curl_init();

        curl_setopt($this->curl, CURLOPT_RETURNTRANSFER, true);

        // Follow redirects to ensure we don't return a redirect response
        curl_setopt($this->curl, CURLOPT_FOLLOWLOCATION, true);
    }

    /**
     * Sets base url to prepend on every request
     *
     * @param string $baseUrl
     * @return Client
     */
    public function setBaseUrl($baseUrl)
    {
        $this->baseUrl = $baseUrl;

        return $this;
    }

    /**
     * Gets the base url
     *
     * @return string
     */
    public function getBaseUrl()
    {
        return $this->baseUrl;
    }

    /**
     * Sets the access token used on every request
     *
     * @param string $accessToken
     * @return Client
     */
    public function setAccessToken($accessToken)
    {
        $this->accessToken = $accessToken;

        return $this;
    }

    /**
     * Gets the current access token
     *
     * @return string
     */
    public function getAccessToken()
    {
        return $this->accessToken;
    }

    /**
     * Sets the tenant token used on every request
     *
     * @param string $tenantToken
     * @return Client
     */
    public function setTenantToken($tenantToken)
    {
        $this->tenantToken = $tenantToken;

        return $this;
    }

    /**
     * Sets the api path used on every request
     *
     * @param string $apiPath
     * @return Client
     */
    public function setApiPath($apiPath)
    {
        $this->apiPath = $apiPath;

        return $this;
    }

    /**
     * Gets the tenant token
     *
     * @return string
     */
    public function getTenantToken()
    {
        return $this->tenantToken;
    }

    /**
     * Gets the api path
     *
     * @return string
     */
    public function getApiPath()
    {
        return $this->apiPath;
    }

    /**
     * Updates the curl headers to include Authorization and
     * x-tenant-token headers
     *
     * @return void
     */
    private function setApiClientHeaders(array $additionalHeaders = array())
    {
        curl_setopt($this->curl, CURLOPT_HTTPHEADER, array_merge(array(
            'Authorization: Bearer ' . $this->accessToken,
            'x-tenant-token: ' . $this->tenantToken
        ), $additionalHeaders));
    }

    /**
     * Sends and formates http request to api
     *
     * @param string       $method    "GET"|"DELETE"|"POST"
     * @param string       $endpoint  Url to append the baseUrl ("$baseUrl/$url")
     * @param string|array $payload   Array: payload is used as query params. String: Array is used as body
     * @return void
     */
    public function request($method, string $endpoint = '/', $payload = null)
    {
        // Formats url for the request. It ensures that you can use
        // beginning and trailing slashes without running into issues
        $url = rtrim($this->baseUrl, '/') . rtrim('/' . ltrim($endpoint, '/'), '/');

        switch (strtoupper($method)) {
            case 'GET':
            case 'DELETE':
                $url = $payload ? $url . '?' . http_build_query($payload) : $url;
                $this->setApiClientHeaders();
                break;
            case 'POST':
                curl_setopt($this->curl, CURLOPT_POST, true);
                curl_setopt($this->curl, CURLOPT_POSTFIELDS, json_encode($payload));
                $this->setApiClientHeaders(['Content-Type: application/json']);
                break;
            default:
                throw new \Exception('Undefined HTTP method', 1);
        }

        curl_setopt($this->curl, CURLOPT_URL, $url);

        $response = curl_exec($this->curl);
        $httpCode = curl_getinfo($this->curl, CURLINFO_HTTP_CODE);

        // Error handling
        if (substr(strval($httpCode), 0, 1) !== "2" && $httpCode !== 404 && $httpCode !== 400) {
            $messageHint = match ($httpCode) {
                0 => "Please check your hostname and port. ",
                500 => 'Please check your tenant token. ',
                default => '',
            };

            $message = isset(json_decode($response)->message) ? '. Error message: ' . json_decode($response)->message : '';

            throw new \Exception($messageHint . "Unhandled HTTP code({$httpCode}) from response: " . $message, 1);
        }

        return $response;
    }

    /**
     * Make a GET http request
     *
     * @param string       $apiPath     Base part of the url to append to the baseUrl: "$baseUrl/$apiPath$url"
     * @param string       $endpoint    End part of the url to append to the base url and api path
     * @param string|array $payload
     * @return string
     */
    public function get(string $apiPath, $endpoint = '', $payload = null)
    {
        $apiPath = $this->apiPath ?? $apiPath;
        return $this->request('GET', $apiPath . $endpoint, $payload);
    }

    /**
     * Make a POST http reqquest
     *
     * @param string       $apiPath      Base part of the url to append to the baseUrl: "$baseUrl/$apiPath$url"
     * @param string       $endpoint     End part of the url to append to the base url and api path
     * @param string|array $payload
     * @return string
     */
    public function post($apiPath, $endpoint, $payload = null)
    {
        $apiPath = $this->apiPath ?? $apiPath;
        return $this->request('POST', $apiPath . $endpoint, $payload);
    }
}
