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

    private $accessToken;
    private $baseUrl;
    private $curl;
    private $tenantToken;
    private $apiPath;
    private $statusCode;

    /**
     * Maximum number of seconds to wait while trying to connect to the
     * upstream before the request is aborted. 0 = wait indefinitely (unsafe).
     *
     * @var int
     */
    private $connectTimeout = 10;

    /**
     * Maximum number of seconds the whole request is allowed to take before
     * curl aborts it. Without this a slow/hanging upstream (Kong → web*-service
     * → BC/NAV) blocks the PHP process forever. 0 = wait indefinitely (unsafe).
     *
     * @var int
     */
    private $timeout = 30;

    /**
     * Gets the active class instance from $instance. If instance is not set
     * Create a new class instance and save it in $instance
     *
     * @param string $baseUrl
     * @param string $accessToken
     * @param string $tenantToken
     * @param string $apiPath
     * @param int|null $connectTimeout Seconds to wait for the connection (null = keep default)
     * @param int|null $timeout        Seconds for the whole request (null = keep default)
     * @return Client
     */
    public static function getInstance($baseUrl = null, $accessToken = null, $tenantToken = null, string $apiPath = null, ?int $connectTimeout = null, ?int $timeout = null)
    {
        if (!self::$instance) {
            self::$instance = new self($baseUrl, $accessToken, $tenantToken, $apiPath, $connectTimeout, $timeout);
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
    private function __construct(?string $baseUrl = null, ?string $accessToken = null, ?string $tenantToken = null, ?string $apiPath = null, ?int $connectTimeout = null, ?int $timeout = null)
    {
        if ($baseUrl) {
            $this->setBaseUrl($baseUrl);
        }
        if ($accessToken) {
            $this->setAccessToken($accessToken);
        }
        if ($tenantToken) {
            $this->setTenantToken($tenantToken);
        }
        if ($apiPath !== null) {
            $this->setApiPath($apiPath);
        }
        if ($connectTimeout !== null) {
            $this->setConnectTimeout($connectTimeout);
        }
        if ($timeout !== null) {
            $this->setTimeout($timeout);
        }

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
     * Gets the tenant token
     *
     * @return string
     */
    public function getTenantToken()
    {
        return $this->tenantToken;
    }

    /**
     * Sets the maximum number of seconds to wait while connecting to the upstream.
     *
     * @param int $connectTimeout
     * @return Client
     */
    public function setConnectTimeout(int $connectTimeout)
    {
        $this->connectTimeout = $connectTimeout;

        return $this;
    }

    /**
     * Gets the connection timeout in seconds.
     *
     * @return int
     */
    public function getConnectTimeout(): int
    {
        return $this->connectTimeout;
    }

    /**
     * Sets the maximum number of seconds the whole request is allowed to take.
     *
     * @param int $timeout
     * @return Client
     */
    public function setTimeout(int $timeout)
    {
        $this->timeout = $timeout;

        return $this;
    }

    /**
     * Gets the request timeout in seconds.
     *
     * @return int
     */
    public function getTimeout(): int
    {
        return $this->timeout;
    }

    /**
     * @param string $apiPath
     * @return void
     */
    private function setApiPath(string $apiPath): void
    {
        $this->apiPath = $apiPath;
    }

    /**
     * @return string
     */
    public function getApiPath($defaultApiPath = null): string|null
    {
        return $this->apiPath ?? $defaultApiPath;
    }

    /**
     * Updates the curl headers to include Authorization and
     * x-tenant-token headers
     *
     * @return void
     */
    private function setApiClientHeaders(array $additionalHeaders = [])
    {
        curl_setopt($this->curl, CURLOPT_HTTPHEADER, array_merge([
            'Authorization: Bearer ' . $this->accessToken,
            'x-tenant-token: ' . $this->tenantToken
        ], $additionalHeaders));
    }

    public function getStatusCode(): int {
        return $this->statusCode;
    }

    private function setStatusCode($statusCode): void {
        $this->statusCode = $statusCode;
    }

    /**
     * Sends and formates http request to api
     *
     * @param string       $method    "GET"|"DELETE"|"POST"
     * @param string       $endpoint  Url to append the baseUrl ("$baseUrl/$url")
     * @param string|array $payload   Array: payload is used as query params. String: Array is used as body
     * @return mixed
     */
    public function request($method, string $endpoint = '/', $payload = null)
    {
        // Formats url for the request. It ensures that you can use
        // beginning and trailing slashes without running into issues
        $url = rtrim($this->baseUrl, '/') . rtrim('/' . ltrim($endpoint, '/'), '/');

        switch (strtoupper($method)) {
            case 'GET':
            case 'DELETE':
                $url = $payload ? $url . '?' . http_build_query($this->recursiveRawurlencode($payload)) : $url;
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

        // Apply timeouts on every request so a slow/hanging upstream cannot block
        // the PHP process indefinitely. Set here (rather than only in the constructor)
        // so runtime overrides via setConnectTimeout()/setTimeout() take effect on the
        // cached singleton. A curl timeout makes CURLINFO_HTTP_CODE 0, which the error
        // handling below surfaces as a catchable \Exception (code 1) instead of a hang.
        curl_setopt($this->curl, CURLOPT_CONNECTTIMEOUT, $this->connectTimeout);
        curl_setopt($this->curl, CURLOPT_TIMEOUT, $this->timeout);

        $response = curl_exec($this->curl);
        $httpCode = curl_getinfo($this->curl, CURLINFO_HTTP_CODE);

        // Always set status code before any return or exception
        $this->setStatusCode($httpCode);

        // Error handling
        if (substr(strval($httpCode), 0, 1) !== '2' && $httpCode !== 404 && $httpCode !== 400) {
            $messageHint = match ($httpCode) {
                0       => 'Please check your hostname and port. ',
                500     => 'Please check your tenant token. ',
                default => '',
            };

            $message = isset(json_decode($response)->message) ? '. Error message: ' . json_decode($response)->message : '';

            throw new \Exception($messageHint . "Unhandled HTTP code({$httpCode}) from response: " . $message, 1);
        }

        if ($httpCode === 404) {
            http_response_code(404);

            return [
                'message'    => $response,
                'statusCode' => http_response_code(404)
            ];
        }

        // A successful 2xx response may legitimately have an empty body (e.g. HTTP 204,
        // or 200/201 with no content). json_decode('') returns null, which downstream
        // callers (ApiObjectResult) would otherwise treat as a hard failure. Return an
        // empty array instead so an empty success is not confused with "no result".
        if ($response === '' || $response === false || $response === null) {
            return [];
        }

        return json_decode($response);
    }

    /**
     * Make a GET http request
     *
     * @param string       $endpoint     Url to append the baseUrl ("$baseUrl/$url")
     * @param string|array $payload
     * @return string
     */
    public function get($endpoint = '', $payload = null)
    {
        return $this->request('GET', $endpoint, $payload);
    }

    /**
     * Make a POST http reqquest
     *
     * @param string       $endpoint     Url to append the baseUrl ("$baseUrl/$url")
     * @param string|array $payload
     * @return string
     */
    public function post($endpoint, $payload = null)
    {
        return $this->request('POST', $endpoint, $payload);
    }

    private function recursiveRawurlencode($array)
    {
        foreach ($array as $value) {
            if (is_array($value)) {
                $this->recursiveRawurlencode($value);
            } else {
                $value = rawurlencode($value);
            }
        }

        return $array;
    }
}