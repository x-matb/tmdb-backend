<?php


use PHPUnit\Framework\TestCase;


class MovieServiceTest extends TestCase
{
    function testIsSingleton() {
        $this->assertEquals(MovieService::getInstance(), MovieService::getInstance());
    }

    function testSearchWithPage() {
        $expected_results = array((object) array("id"=>1));
        $expected = (object) array("results"=> $expected_results);
        $mock = $this->getMockBuilder(MovieService::class)->disableOriginalConstructor()
            ->setMethodsExcept(array('search'))->getMock();
        $mock->method('request')->willReturn($expected);
        $searchOutput = $mock->search('title', 1);
        $this->assertEquals($expected_results, $searchOutput);
    }

    function testSearch() {
        $expected_results = array((object) array("id"=>2));
        $expected = (object) array("results"=> $expected_results);
        $mock = $this->getMockBuilder(MovieService::class)->disableOriginalConstructor()
            ->setMethodsExcept(array('search'))->getMock();
        $mock->method('request')->willReturn($expected);
        $searchOutput = $mock->search('title');
        $this->assertEquals($expected_results, $searchOutput);
    }

    function testUpcomingsWithPage() {
        $expected_results = array((object) array("id"=>1));
        $expected = (object) array("results"=> $expected_results);
        $mock = $this->getMockBuilder(MovieService::class)->disableOriginalConstructor()
            ->setMethodsExcept(array('upcomings'))->getMock();
        $mock->method('request')->willReturn($expected);
        $upcomings = $mock->upcomings(1);
        $this->assertEquals($expected_results, $upcomings);
    }

    function testUpcomings() {
        $expected_results = array((object) array("id"=>2));
        $expected = (object) array("results"=> $expected_results);
        $mock = $this->getMockBuilder(MovieService::class)->disableOriginalConstructor()
            ->setMethodsExcept(array('upcomings'))->getMock();
        $mock->method('request')->willReturn($expected);
        $upcomings = $mock->upcomings();
        $this->assertEquals($expected_results, $upcomings);
    }

    function testRetrieve() {
        $expected = (object) array("id"=>2);
        $mock = $this->getMockBuilder(MovieService::class)->disableOriginalConstructor()
            ->setMethodsExcept(array('retrieve'))->getMock();
        $mock->method('request')->willReturn($expected);
        $retrieve = $mock->retrieve(123);
        $this->assertEquals($expected, $retrieve);
    }

    function testRequest() {
        $expected = (object) array("results"=> (object) array("id"=>1));
        $mock = $this->getMockBuilder(MovieService::class)->disableOriginalConstructor()
            ->setMethodsExcept(array('request'))->getMock();
        $mock->method('get')->willReturn('{"results":{"id": 1}}');
        $this->assertEquals($expected , $mock->request('test', ''));
    }

}
