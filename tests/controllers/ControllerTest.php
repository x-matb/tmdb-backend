<?php


use PHPUnit\Framework\TestCase;

class NotAbstractController extends Controller
{
    function dispatch(): JsonResponse {}
}

class ControllerTest extends TestCase
{
    function testConstruct() {
        $args = array('pk'=>123);
        $controller = new NotAbstractController($args);
        $this->assertEquals($args, $controller->args);
    }
}
