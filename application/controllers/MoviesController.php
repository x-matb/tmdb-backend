<?php

class MoviesController extends Controller
{
    public $movieService = null;

    function __construct(array $args = array())
    {
        parent::__construct($args);
        $this->movieService = MovieService::getInstance();
    }

    function get($request)
    {
        $movie = Movie::get($this->args['pk']);
        if (is_null($movie->id)) {
            $movie = Movie::createFromObject($this->movieService->retrieve($this->args['pk']));
        }
        return $movie;
    }

    function list($request)
    {
        if (isset($request['get']['title'])) {
            $list = $this->movieService->search($request['get']['title'], $request['get']['page'] ?? 1);
        } else {
            $list = $this->movieService->upcomings($request['get']['page'] ?? 1);
        }
        return Movie::createFromObjectList($list);
    }

    function dispatch($request): JsonResponse {
        if (isset($this->args['pk'])) {
            $data = $this->get($request);
        } else {
            $data = $this->list($request);
        }
        return new JsonResponse($data);
    }
}