<?php


use PHPUnit\Framework\TestCase;

class GenreTest extends TestCase
{
    function testConstructSetProperties() {
        $genre = new Genre(1, 'test');
        $this->assertEquals(1, $genre->id);
        $this->assertEquals(1, $genre->name);
    }
}
