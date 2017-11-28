<?php


interface CacheServiceInterface
{
    function set($key, $value);

    function get($key);

    function flush();
}