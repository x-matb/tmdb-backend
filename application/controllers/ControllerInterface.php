<?php

interface ControllerInterface
{
    function dispatch(): JsonResponse;
}