<?php

interface ControllerInterface
{
    function dispatch($request): JsonResponse;
}