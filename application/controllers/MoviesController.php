<?php

class MoviesController extends Controller
{
    public $movieService = null;

    function get($request)
    {
        $data = $this->movieService->retrieve($this->args['pk']);
        return $data;
    }

    function __construct(array $args = array())
    {
        parent::__construct($args);
        $this->movieService = MovieService::getInstance();
    }

    function list($request)
    {
        if (isset($request['get']['title'])) {
            return $this->movieService->search($request['get']['title'], $request['get']['page'] ?? 1);
        } else {
            return $this->movieService->upcomings($request['get']['page'] ?? 1);
        }
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