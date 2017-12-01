<?php


use PHPUnit\Framework\TestCase;

class RedisCacheTest extends TestCase
{
    private $redis;
    function setUp()
    {
        $redis = RedisCache::getInstance();
        $redis->flush();
        $this->redis = $redis;
    }

    function testGetWithoutValue() {
        $data = $this->redis->get('123');
        $this->assertNull($data);
    }

    function testSet() {
        $expected = (object) array('test'=>'test');

        $this->redis->set('123', $expected);
        $data = $this->redis->get('123');
        $this->assertEquals($expected, $data);
    }

    function testSetUpdates() {
        $expected = (object) array('test'=>'test');
        $this->redis->set('123', null);
        $this->redis->set('123', $expected);
        $data = $this->redis->get('123');
        $this->assertEquals($expected, $data);
    }


}
