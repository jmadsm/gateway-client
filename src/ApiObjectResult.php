<?php

namespace JmaDsm\GatewayClient;

class ApiObjectResult
{
    protected $data;

    public function __construct($data)
    {
        $this->data = $data;
    }

    public function next()
    {
        return $this->data;
    }
}
