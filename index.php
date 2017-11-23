<?php

function autoloadPath($path, $name) {
    $file = __DIR__ . '/' . $path . $name . '.php';
    if (file_exists($file)) {
        require_once $file;
    }
}

function autoload($name) {
    # TODO: Improve to pass dir dinamically
    autoloadPath('/', $name);
    autoloadPath('application/', $name);
    autoloadPath('application/controllers/', $name);
    autoloadPath('application/views/', $name);
}

spl_autoload_register('autoload');

$urls = Array(
    "/^\/movies\/?$/" => 'MoviesController',
    '/^\/movies\/(?<pk>[0-9]+)\/?$/' => 'MovieController'
);


$router = new Router($_SERVER, $urls);
$router->run();
