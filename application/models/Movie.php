<?php


class Movie
{
    public $name, $image, $releaseDate, $overview, $id;
    public $genres;

    function __construct($id, $name, $image, $releaseDate, $overview)
    {
        $this->id = $id;
        $this->name = $name;
        $this->image = $image;
        $this->releaseDate = $releaseDate;
        $this->overview = $overview;
//        $this->genres = new ArrayObject();
    }

    static function createFromObject($obj) {
        $id = $obj->id;
        $name = $obj->original_title;
        $image = $obj->poster_path ?? $obj->backdrop_path;
        $releaseDate = $obj->release_date;
        $overview = $obj->overview;
        return new Movie($id, $name, $image, $releaseDate, $overview);
    }

    static function createFromObjectList($list) {
        $newList = array();
        foreach ($list as $obj) {
            array_push($newList, self::createFromObject($obj));
        }
        return $newList;
    }

//    function addGenre($genre) {
//        $this->genres->append($genre);
//    }
//
//    function removeGenre($genre) {
//        $this->genres->
//        for ($this->genres as $existingGenre) {
//            if ($existingGenre->id == $genre->id) {
//
//            }
//        }
//        $this->genres
//    }

}