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
    protected bool $firstElement = true;

    /**
     * @param $result
     * @param $method
     * @param $parameters
     */
    public function __construct($result, $method, $page, $parameters)
    {
        $this->updateThisObject($result, $method, $page, $parameters);
    }

    /**
     * @param $result
     * @param $method
     * @param $parameters
     */
    private function updateThisObject($result, $method, $page, $parameters): void
    {
        $this->data           = $result->data ?: null;
        $this->method         = $method;
        $this->page           = $page;
        $this->parameters     = $parameters;
        $this->to             = $result->to ?: 0;
        $this->total          = $result->total ?: 0;
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
        if (current($this->data)) return true;

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
        $resultNextPage = call_user_func_array($this->method, array_merge([$this->page], $this->parameters));

        // Update variables for this ApiObjectResult with data from the next page
        $this->updateThisObject($resultNextPage, $this->method, $this->page, $this->parameters);

        return true;
    }
}
