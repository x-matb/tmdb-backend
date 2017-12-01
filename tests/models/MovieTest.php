<?php


use PHPUnit\Framework\TestCase;

class MovieTest extends TestCase
{
    function testConstructSetProperties() {
        $obj = (object) array(
            'id' => 1,
            'original_title' => 'title',
            'poster_path' => '/path.jpg',
            'release_date' => '2016-10-10',
            'overview' => 'this is an overview',
            'genres' => array(
                (object) array('id' => 27, 'name' => 'Horror')
            )
        );
        $genre = new Movie($obj->id, $obj->original_title, $obj->poster_path, $obj->release_date, $obj->overview);
        $this->assertMovieEqualToObj($obj, $genre);
    }

    function assertMovieEqualToObj($obj, $movie) {
        $this->assertEquals($obj->id, $movie->id);
        $this->assertEquals($obj->original_title, $movie->name);
        if (property_exists($obj, 'poster_path')) {
            $this->assertEquals($obj->poster_path, $movie->image);
        } else {
            $this->assertEquals($obj->backdrop_path, $movie->image);
        }
        $this->assertEquals($obj->release_date, $movie->releaseDate);
        $this->assertEquals($obj->overview, $movie->overview);
    }

    function testCreateFromObject() {
        Movie::delete(1);
        $countBeforeMovies = Database::getInstance()->count('Movies');
        $countBeforeMoviesGenres = Database::getInstance()->count('MoviesGenres');

        $obj = (object) array(
            'id' => 1,
            'original_title' => 'title',
            'poster_path' => '/path.jpg',
            'release_date' => '2016-10-10',
            'overview' => 'this is an overview',
            'genres' => array(
                (object) array('id' => 27, 'name' => 'Horror')
            )
        );
        $out = Movie::createFromObject($obj);
        $this->assertMovieEqualToObj($obj, $out);
        $this->assertEquals($countBeforeMovies+1, Database::getInstance()->count('Movies'));
        $this->assertEquals($countBeforeMoviesGenres+1, Database::getInstance()->count('MoviesGenres'));
    }

    function testCreateFromObjectWithGenreIds() {
        Movie::delete(1);
        $countBeforeMovies = Database::getInstance()->count('Movies');
        $countBeforeMoviesGenres = Database::getInstance()->count('MoviesGenres');

        $obj = (object) array(
            'id' => 1,
            'original_title' => 'title',
            'poster_path' => '/path.jpg',
            'release_date' => '2016-10-10',
            'overview' => 'this is an overview',
            'genre_ids' => array(27, 53)
        );
        $out = Movie::createFromObject($obj);
        $this->assertMovieEqualToObj($obj, $out);
        $this->assertEquals($countBeforeMovies+1, Database::getInstance()->count('Movies'));
        $this->assertEquals($countBeforeMoviesGenres+2, Database::getInstance()->count('MoviesGenres'));
    }

    function testCreateFromObjectWithBackdrop() {
        $obj = (object) array(
            'id' => 1,
            'original_title' => 'title',
            'backdrop_path' => '/path.jpg',
            'release_date' => '2016-10-10',
            'overview' => 'this is an overview'
        );
        $out = Movie::createFromObject($obj);
        $this->assertMovieEqualToObj($obj, $out);
    }

    function testeCreateFromObjectList() {
        $obj = (object) array(
            'id' => 1,
            'original_title' => 'title',
            'backdrop_path' => '/path.jpg',
            'release_date' => '2016-10-10',
            'overview' => 'this is an overview'
        );
        $obj1 = (object) array(
            'id' => 2,
            'original_title' => 'title2',
            'backdrop_path' => '/path2.jpg',
            'release_date' => '2017-10-10',
            'overview' => '2 this is an overview'
        );
        $list = array($obj, $obj1);
        $out_list = Movie::createFromObjectList($list);
        $this->assertMovieEqualToObj($obj, $out_list[0]);
        $this->assertMovieEqualToObj($obj1, $out_list[1]);
    }
}
