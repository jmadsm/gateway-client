<?php

namespace JmaDsm\GatewayClient;

class ApiObjectResult
{
    protected $data;
    protected string $method;
    protected array $parameters;
    protected int $to;
    protected int $total;
    protected int $page;
    protected int $perPage;
    protected array $content;
    protected bool $firstElement = true;

    /**
     * @param $result
     * @param $method
     * @param array $parameters
     */
    public function __construct($result, string $method = '', int $page = 1, array $parameters = [], int $perPage = 25)
    {
        if (is_null($result)) {
            http_response_code(404);
            die('No result. Please check your URL and API Path.');
        }

        $this->updateThisObject($result, $method, $page, $parameters, $perPage);
    }

    /**
     * @param $result
     * @param $method
     * @param $parameters
     */
    private function updateThisObject($result, $method, $page, $parameters, $perPage = 25): void
    {
        $this->data           = $result->data ?? $result ?? null;
        $this->perPage        = $perPage;
        $this->method         = $method;
        $this->page           = $page;
        $this->parameters     = $parameters;
        $this->to             = $result->to ?? 0;
        $this->total          = $result->total ?? 0;
        $this->content        = (array) $result ?? [];
    }

    /**
     * Return next element in data result.
     * Return null, when there are no more elements.
     *
     * @return mixed|null
     */
    public function next()
    {
        if (!$this->updateElements()) {
            return null;
        }
        // return the next element
        return current($this->data);
    }

    /**
     * Return the element that is currently pointed to
     * This will return the first element, when ApiObjectResult is newly created
     *
     * @return false|mixed
     */
    public function getCurrentElement()
    {
        if (is_null($this->data)) {
            return null;
        }

        return current($this->data);
    }

    /**
     * Point to the next element to be returned, and return true.
     * If there are no more elements, get the next page, which will point to the first element on that page.
     * If there are still no more elements, return false
     *
     * @return bool
     */
    protected function updateElements(): bool
    {
        // First element: do nothing
        if ($this->firstElement) {
            $this->firstElement = false;

            return isset($this->data);
        }

        // If there are more elements left on the current page, step to the next one and return true
        next($this->data);
        if (current($this->data)) {
            return true;
        }

        // If no more elements are left: get the next page if it exists. Return false if not
        return $this->getNextPage();
    }

    /**
     * @return bool
     */
    protected function getNextPage(): bool
    {
        // Return false if there are no more pages
        if ($this->to === $this->total) {
            return false;
        }

        // Get result for next page from API
        $this->page++;
        //die(var_dump($this->method));
        $resultNextPage = call_user_func_array($this->method, array_merge([$this->page], $this->parameters));

        // Update variables for this ApiObjectResult with data from the next page
        $this->updateThisObject($resultNextPage, $this->method, $this->page, $this->parameters, $this->perPage);

        return true;
    }

    /**
     * @return mixed
     */
    public function getData()
    {
        return $this->data;
    }

    /**
     * @return string
     */
    public function getMethod(): string
    {
        return $this->method;
    }

    /**
     * @return array
     */
    public function getParameters(): array
    {
        return $this->parameters;
    }

    /**
     * @return int
     */
    public function getTo(): int
    {
        return $this->to;
    }

    /**
     * @return int
     */
    public function getTotal(): int
    {
        return $this->total;
    }

    /**
     * @return int
     */
    public function getPage(): int
    {
        return $this->page;
    }

    /**
     * @return int
     */
    public function getPerPage(): int
    {
        return $this->perPage;
    }

    /**
     * @return array
     */
    public function getContent(): array
    {
        return $this->content;
    }
}
