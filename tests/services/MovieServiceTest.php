<?php


use PHPUnit\Framework\TestCase;


class MovieServiceTest extends TestCase
{
    function testIsSingleton() {
        $this->assertEquals(MovieService::getInstance(), MovieService::getInstance());
    }

    function testSearchWithPage() {
        $expected = array(1);
        $mock = $this->getMockBuilder(MovieService::class)->disableOriginalConstructor()
            ->setMethodsExcept(array('search'))->getMock();
        $mock->method('request')->willReturn($expected);
        $searchOutput = $mock->search('title', 1);
        $this->assertEquals($expected, $searchOutput);
    }

    function testSearch() {
        $expected = array(2);
        $mock = $this->getMockBuilder(MovieService::class)->disableOriginalConstructor()
            ->setMethodsExcept(array('search'))->getMock();
        $mock->method('request')->willReturn($expected);
        $searchOutput = $mock->search('title');
        $this->assertEquals($expected, $searchOutput);
    }

    function testUpcomingsWithPage() {
        $expected = array(1);
        $mock = $this->getMockBuilder(MovieService::class)->disableOriginalConstructor()
            ->setMethodsExcept(array('upcomings'))->getMock();
        $mock->method('request')->willReturn($expected);
        $upcomings = $mock->upcomings(1);
        $this->assertEquals($expected, $upcomings);
    }

    function testUpcomings() {
        $expected = array(2);
        $mock = $this->getMockBuilder(MovieService::class)->disableOriginalConstructor()
            ->setMethodsExcept(array('upcomings'))->getMock();
        $mock->method('request')->willReturn($expected);
        $upcomings = $mock->upcomings();
        $this->assertEquals($expected, $upcomings);
    }

    function testRequest() {
        $mock = $this->getMockBuilder(MovieService::class)->disableOriginalConstructor()
            ->setMethodsExcept(array('request'))->getMock();
        $mock->method('get')->willReturn('{"results":[]}');
        $this->assertEquals(array(), $mock->request('test', ''));
    }

}
