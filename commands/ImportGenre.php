<?php

require_once __DIR__  . '/../application/services/Database.php';
require_once __DIR__ . '/../application/services/MovieServiceInterface.php';
require_once __DIR__ . '/../application/services/MovieService.php';

class ImportGenre
{
    function __construct()
    {
        $db = Database::getInstance();
        $genres = MovieService::getInstance()->genreList();
        print_r($genres);
        foreach ($genres as $genre) {
            $bind = array(
                ':id' => $genre->id,
                ':name' => $genre->name
            );
            $db->insert('insert into Genres values (:id, :name)', $bind);
        }
    }
}

new ImportGenre();