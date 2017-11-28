<?php

class CachedMoviesController extends MoviesController {

    public $cacheService = null;

    function __construct(array $args = array())
    {
        parent::__construct($args);
        $this->cacheService = RedisCache::getInstance();
    }

    function get($request) {
        $pk = $this->args['pk'];
        $cacheKey = "get-{$pk}";
        if ($data = $this->cacheService->get($cacheKey)) {
            return $data;
        } else {
            $data = parent::get($request);
            $this->cacheService->set($cacheKey, $data);
            return $data;
        }
    }

    function list($request) {
        $page = $request['get']['page'] ?? 1;
        if (isset($request['get']['title'])) {
            $title = $request['get']['title'];
            $cacheKey = "list-search-{$title}-{$page}";
        } else {
            $cacheKey = "list-upcomings-{$page}";
        }

        if ($data = $this->cacheService->get($cacheKey)) {
            return $data;
        } else {
            $data = parent::list($request);
            $this->cacheService->set($cacheKey, $data);
            return $data;
        }
    }

}
