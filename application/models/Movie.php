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
        $this->genres = array();
    }

    public static function get($id) {
        $bind = array(
            ':id' => $id
        );
        $st = 'select * from Movies where id = :id';
        $data = Database::getInstance()->fetch($st, $bind);
        $movie = new Movie($data['id'], $data['name'], $data['image'], $data['release_date'], $data['overview']);
        $movie->loadGenres();
        return $movie;
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
        $r = Database::getInstance()->insert($st, $bind);
        return $r['rowsAffected'] > 0;
    }

    static function createFromObject($obj) {
        $id = $obj->id;
        $name = $obj->original_title;
        $image = $obj->poster_path ?? $obj->backdrop_path;
        $releaseDate = $obj->release_date;
        $overview = $obj->overview;
        $movie = new Movie($id, $name, $image, $releaseDate, $overview);
        if (property_exists($obj, 'genres')) {
            foreach ($obj->genres as $genre) {
                $movie->addGenre(new Genre($genre->id, $genre->name));
            }
        }

        if (property_exists($obj, 'genre_ids')) {
            foreach ($obj->genre_ids as $genre) {
                $movie->addGenre(new Genre($genre));
            }
        }
        if ($movie->save()) {
            foreach ($movie->genres as $genre) {
                $genre->associateMovie($movie->id);
            }
        }
        $movie->genres = array();
        $movie->loadGenres();
        return $movie;
    }

    static function createFromObjectList($list) {
        $newList = array();
        foreach ($list as $obj) {
            array_push($newList, self::createFromObject($obj));
        }
        return $newList;
    }

    function addGenre($genre) {
        array_push($this->genres, $genre);
    }

    function loadGenres() {
        $bind = array(
            ':id' => $this->id
        );
        $st = 'select g.* from Genres g left join MoviesGenres mg on g.id=mg.genre_id where mg.movie_id = :id';
        $data = Database::getInstance()->fetchAll($st, $bind);
        foreach ($data as $genreData) {
            $genre = new Genre((int) $genreData['id'], $genreData['name']);
            array_push($this->genres, $genre);
        }
    }
}