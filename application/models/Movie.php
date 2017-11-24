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

    public static function get($id) {
        $bind = array(
            ':id' => $id
        );
        $st = 'select * from Movies where id = :id';
        $data = Database::getInstance()->fetch($st, $bind);
        return new Movie($data['id'], $data['name'], $data['image'], $data['release_date'], $data['overview']);
    }

    public static function delete($id) {
        $bind = array(
            ':id' => $id
        );
        $st = 'delete from Movies where id = :id';
        $data = Database::getInstance()->delete($st, $bind);
    }

    function save() {
        $bind = array(
            ":id" => $this->id,
            ":name" => $this->name,
            ":image" => $this->image,
            ":releaseDate" => $this->releaseDate,
            ":overview" => $this->overview
        );
        $st = 'INSERT IGNORE Movies values (:id, :name, :image, :releaseDate, :overview)';
        Database::getInstance()->insert($st, $bind);
    }

    static function createFromObject($obj) {
        $id = $obj->id;
        $name = $obj->original_title;
        $image = $obj->poster_path ?? $obj->backdrop_path;
        $releaseDate = $obj->release_date;
        $overview = $obj->overview;
        $movie = new Movie($id, $name, $image, $releaseDate, $overview);
        $movie->save();
        return $movie;
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