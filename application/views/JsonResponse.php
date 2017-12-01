<?php

class JsonResponse
{
    private $contentType, $content;

    function __construct($data)
    {
        $this->contentType = 'Content-Type: application/json';
        $this->content = json_encode($data);
    }

    function getContent()
    {
        return $this->content;
    }

    function getContentType()
    {
        return $this->contentType;
    }
}