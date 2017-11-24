<?php


use PHPUnit\Framework\TestCase;

class JsonResponseTest extends TestCase
{
    function testConstructorSetContentType()
    {
        $response = new JsonResponse(array());
        $this->assertEquals('Content-Type: application/json', $response->getContentType());
    }

    function testConstructorSetContent()
    {
        $response = new JsonResponse(array());
        $this->assertEquals("[]", $response->getContent());
    }

    function testConstructorSetContentObject()
    {
        $response = new JsonResponse(array('a'=>array('b')));
        $this->assertEquals("{\"a\":[\"b\"]}", $response->getContent());
    }

}
