<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);
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
require __DIR__ . '/vendor/autoload.php';

$urls = Array(
    "/^\/movies\/?$/" => 'CachedMoviesController',
    '/^\/movies\/(?<pk>[0-9]+)\/?$/' => 'CachedMoviesController'
);


$router = new Router($_SERVER, $urls);
$router->run();
