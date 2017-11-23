<?php

interface MovieServiceInterface
{
    function search($title, $page): array;

    function upcomings($page): array;

    function retrieve($id): stdClass;

}