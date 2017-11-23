<?php

abstract class Controller implements ControllerInterface
{
    public $args;

    function __construct($args=array())
    {
        $this->args = $args;
    }
}