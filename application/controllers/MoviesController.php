<?php

class MoviesController extends Controller
{
    function get()
    {

    }

    function list()
    {
    }

    function dispatch(): JsonResponse {
        if (isset($this->args['pk'])) {
            $data = $this->get();
        } else {
            $data = $this->list();
        }
        return new JsonResponse($data);
    }
}