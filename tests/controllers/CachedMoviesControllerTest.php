<?php

use PHPUnit\Framework\TestCase;

class CachedMoviesControllerTest extends TestCase
{

    function testGetFromCache() {
        $expected = (object) array(
            'id' => 1,
            'original_title' => 'title',
            'poster_path' => '/path.jpg',
            'release_date' => '2016-10-10',
            'overview' => 'this is an overview'
        );
        $mock = $this->createMock(RedisCache::class);
        $mock->method('get')->willReturn($expected);
        $controller = new CachedMoviesController(array('pk'=> 1));
        $controller->cacheService = $mock;
        $this->assertEquals($expected, $controller->get(array()));
    }

    function testGetMiss() {
        RedisCache::getInstance()->flush();
        $expected = (object) array(
            'id' => 1,
            'original_title' => 'title',
            'poster_path' => '/path.jpg',
            'release_date' => '2016-10-10',
            'overview' => 'this is an overview'
        );
        $mockRedis = $this->createMock(RedisCache::class);
        $mock = $this->createMock(MovieService::class);
        $mock->method('retrieve')->willReturn($expected);
        $controller = new CachedMoviesController(array('pk'=> 1));
        $controller->cacheService = $mockRedis;
        $controller->movieService = $mock;
        $this->assertInstanceOf(Movie::class, $controller->get(array()));
    }

    function testListSearchFromCache() {
        $expected = array((object) array(
            'id' => 1,
            'original_title' => 'title',
            'poster_path' => '/path.jpg',
            'release_date' => '2016-10-10',
            'overview' => 'this is an overview'
        ));
        $mock = $this->createMock(RedisCache::class);
        $mock->method('get')->willReturn($expected);
        $controller = new CachedMoviesController();
        $controller->cacheService = $mock;
        $this->assertEquals($expected, $controller->list(array('get'=> array('title'=>'something'))));
    }

    function testListSearchMiss() {
        RedisCache::getInstance()->flush();
        $input = array((object) array(
            'id' => 1,
            'original_title' => 'title',
            'poster_path' => '/path.jpg',
            'release_date' => '2016-10-10',
            'overview' => 'this is an overview'
        ));
        $movie = new Movie(1, 'title', '/path.jpg', '2016-10-10', 'this is an overview');
        $movie->genres = array(new Genre(27, 'Horror'), new Genre(53, 'Thriller'));
        $expected = array($movie);
        $mockRedis = $this->createMock(RedisCache::class);
        $mock = $this->createMock(MovieService::class);
        $mock->method('search')->willReturn($input);
        $controller = new CachedMoviesController();
        $controller->cacheService = $mockRedis;
        $controller->movieService = $mock;
        $this->assertEquals($expected, $controller->list(array('get'=> array('title'=>'something'))));
    }

    function testUpcomingsFromCache() {
        $expected = array((object) array(
            'id' => 1,
            'original_title' => 'title',
            'poster_path' => '/path.jpg',
            'release_date' => '2016-10-10',
            'overview' => 'this is an overview'
        ));
        $mock = $this->createMock(RedisCache::class);
        $mock->method('get')->willReturn($expected);
        $controller = new CachedMoviesController();
        $controller->cacheService = $mock;
        $this->assertEquals($expected, $controller->list(array('get'=> array())));
    }

    function testUpcomingsMiss() {
        RedisCache::getInstance()->flush();
        $input = array((object) array(
            'id' => 1,
            'original_title' => 'title',
            'poster_path' => '/path.jpg',
            'release_date' => '2016-10-10',
            'overview' => 'this is an overview'
        ));
        $movie = new Movie(1, 'title', '/path.jpg', '2016-10-10', 'this is an overview');
        $movie->genres = array(new Genre(27, 'Horror'), new Genre(53, 'Thriller'));
        $expected = array($movie);
        $mockRedis = $this->createMock(RedisCache::class);
        $mock = $this->createMock(MovieService::class);
        $mock->method('upcomings')->willReturn($input);
        $controller = new CachedMoviesController();
        $controller->cacheService = $mockRedis;
        $controller->movieService = $mock;
        $this->assertEquals($expected, $controller->list(array('get'=> array())));
    }
}
