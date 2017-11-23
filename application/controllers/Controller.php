<?php

abstract class Controller implements ControllerInterface
{
    function __construct($args=array())
    {
        $this->args = $args;
    }
}