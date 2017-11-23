<?php


use PHPUnit\Framework\TestCase;

class MoviesControllerTest extends TestCase
{
    function testDispatchToGet()
    {
        $expected = 1;
        $mock = $this->getMockBuilder(MoviesController::class)->disableOriginalConstructor()
            ->setMethodsExcept(array('dispatch'))->getMock();
        $mock->args = array('pk' => 123);
        $mock->method('get')->willReturn($expected);
        $this->assertEquals($expected, $mock->dispatch(Array())->getContent());
    }

    function testDispatchToList()
    {
        $mock = $this->getMockBuilder(MoviesController::class)->disableOriginalConstructor()
            ->setMethodsExcept(array('dispatch'))->getMock();
        $mock->method('list')->willReturn([1, 2]);
        $this->assertEquals('[1,2]', $mock->dispatch(Array())->getContent());
    }


    function testListCallUpcomings()
    {
        $expected = array(1);
        $mock = $this->createMock(MovieService::class);
        $mock->method('upcomings')->willReturn($expected);
        $controller = new MoviesController();
        $controller->movieService = $mock;
        $this->assertEquals($expected, $controller->list(array('get'=> array())));
    }

    function testListCallSearch()
    {
        $expected = array(2);
        $mock = $this->createMock(MovieService::class);
        $mock->method('search')->willReturn($expected);
        $controller = new MoviesController();
        $controller->movieService = $mock;
        $this->assertEquals($expected, $controller->list(array('get'=> array('title'=>'something'))));
    }

    function testGetCallRetrieve()
    {
        $expected = (object) array(2);
        $mock = $this->createMock(MovieService::class);
        $mock->method('retrieve')->willReturn($expected);
        $controller = new MoviesController(array('pk'=> 1));
        $controller->movieService = $mock;
        $this->assertEquals($expected, $controller->get(array('get'=> array('title'=>'something'))));
    }
}
