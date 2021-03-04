<?php

namespace YouTube\Responses;

use Curl\Response;

abstract class HttpResponse
{
    private $statusCode = null;
    private $responseBody = null;

    public function getStatusCode()
    {
        return $this->statusCode;
    }

    public function setStatusCode($statusCode)
    {
        $this->statusCode = $statusCode;
    }

    public function setResponseBody($responseBody)
    {
        $this->responseBody = $responseBody;
        $this->json = json_decode($responseBody, true);
    }

    /**
     * @var Response
     */
    private $response;

    // Will become null if response contents cannot be decoded from JSON
    private $json;

    public function __construct(Response $response = null)
    {
        if ($response) {
            $this->response = $response;
            $this->json = json_decode($response->body, true);
        }
    }

    public function getResponse()
    {
        return $this->response;
    }

    /**
     * @return string|null
     */
    public function getResponseBody()
    {
        return $this->responseBody ?? $this->response->body;
    }

    /**
     * @return array|null
     */
    public function getJson()
    {
        return $this->json;
    }

    public function isStatusOkay()
    {
        return ($this->statusCode ?? $this->getResponse()->status) == 200;
    }
}
