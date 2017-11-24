<?php


class Genre
{
    public $id, $name;

    function __construct($id, $name=null)
    {
        $this->id = $id;
        $this->name = $name;
    }

    public function associateMovie($movie_id) {
        $bind = array(
            ':genre_id' => $this->id,
            ':movie_id' => $movie_id
        );
        $st = 'insert ignore MoviesGenres values (:movie_id, :genre_id)';
        $data = Database::getInstance()->insert($st, $bind);
    }
}