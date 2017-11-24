<?php


use PHPUnit\Framework\TestCase;

class GenreTest extends TestCase
{
    function testConstructSetProperties() {
        $genre = new Genre(1, 'test');
        $this->assertEquals(1, $genre->id);
        $this->assertEquals('test', $genre->name);
    }

    function testAssociate() {
        Movie::delete(1);
        $obj = (object) array(
            'id' => 1,
            'original_title' => 'title',
            'poster_path' => '/path.jpg',
            'release_date' => '2016-10-10',
            'overview' => 'this is an overview'
        );
        $countBefore = Database::getInstance()->count('MoviesGenres');
        $out = Movie::createFromObject($obj);
        $genre = new Genre(27);
        $genre->associateMovie($out->id);
        $this->assertEquals($countBefore+1, Database::getInstance()->count('MoviesGenres'));
    }
}
