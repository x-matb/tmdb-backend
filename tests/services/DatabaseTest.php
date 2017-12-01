<?php


use PHPUnit\Framework\TestCase;

class DatabaseTest extends TestCase
{
    function testIsSingleton() {
        $this->assertEquals(Database::getInstance(), Database::getInstance());
    }
}
