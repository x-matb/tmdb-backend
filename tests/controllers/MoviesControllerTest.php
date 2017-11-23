<?php


use PHPUnit\Framework\TestCase;

class MoviesControllerTest extends TestCase
{
    function testDispatchToGet()
    {
        $mock = $this->getMockBuilder(MoviesController::class)->disableOriginalConstructor()
            ->setMethodsExcept(array('dispatch'))->getMock();
        $mock->args = array('pk' => 123);
        $mock->method('get')->willReturn(1);
        $this->assertEquals(1, $mock->dispatch()->getContent());
    }

    function testDispatchToList()
    {
        $mock = $this->getMockBuilder(MoviesController::class)->disableOriginalConstructor()
            ->setMethodsExcept(array('dispatch'))->getMock();
        $mock->method('list')->willReturn([1, 2]);
        $this->assertEquals('[1,2]', $mock->dispatch()->getContent());
    }
}
