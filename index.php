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
    autoloadPath('application/views/', $name);
    autoloadPath('application/controllers/', $name);
    autoloadPath('application/models/', $name);
    autoloadPath('application/services/', $name);
}

spl_autoload_register('autoload');


$urls = Array(
    "/^\/movies\/?$/" => 'MoviesController',
    '/^\/movies\/(?<pk>[0-9]+)\/?$/' => 'MoviesController'
);


$router = new Router($_SERVER, $urls);
$router->run();
