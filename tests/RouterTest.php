<?php

use PHPUnit\Framework\TestCase;


class TestRouter extends TestCase
{
    protected $urls;


    protected function setUp()
    {

        $this->urls =  Array(
            "/^\/test\/?$/" => $this->createMock(MoviesController::class),
            "/^\/test\/(?<pk>[0-9]+)\/?$/" => $this->createMock(MoviesController::class)
        );
    }

    protected function tearDown()
    {
        $this->urls = null;
    }

    function testConstructSetRouterUrl()
    {
        $router = new Router(Array('REDIRECT_URL'=>'test'), $this->urls);

        $this->assertEquals(
            $this->urls,
            $router->urls
        );

        $this->assertEquals(
          'test',
          $router->request_uri
        );
    }

    function testFetchControllerInvalidURI()
    {
        $router = new Router(Array('REDIRECT_URL'=>'invalid_path'), $this->urls);
        $controller = $router->fetchController();
        $this->assertNull($controller);
        return $router;
    }

    function testFetchControllerValidURI()
    {
        $router = new Router(Array('REDIRECT_URL'=>'/test'), $this->urls);
        $controller = $router->fetchController();
        $this->assertInstanceOf(MoviesController::class, $controller);
        return $router;
    }

    function testFetchControllerValidURIWithQuery()
    {
        $router = new Router(Array('REDIRECT_URL'=>'/test'), $this->urls);
        $controller = $router->fetchController();
        $this->assertInstanceOf(MoviesController::class, $controller);
        return $router;
    }

    function testFetchControllerValidURIWithPK()
    {
        $router = new Router(Array('REDIRECT_URL'=>'/test/123'), $this->urls);
        $controller = $router->fetchController();
        $this->assertInstanceOf(MoviesController::class, $controller);
        $this->assertEquals(
            '123',
            $controller->args['pk']
        );
    }

    /**
     * @depends testFetchControllerInvalidURI
     */
    function testRunWithoutController($router)
    {
        $output = $router->run();
        $this->assertEquals(null, $output);
        $this->assertEquals(404, http_response_code());
    }


    function testReturn500OnException()
    {
        $mock = $this->getMockBuilder(Router::class)->disableOriginalConstructor()
            ->setMethodsExcept(array('run', 'fetchController'))->getMock();

        $mock->urls = $this->urls;
        $mock->request_uri = '/test/123';
        $mock->method('dispatchController')->will($this->throwException(new Exception()));

        $output = $mock->run();
        $this->assertEquals(null, $output);
        $this->assertEquals(500, http_response_code());
    }

    function testRunController()
    {
        # TODO: Create test
    }
}