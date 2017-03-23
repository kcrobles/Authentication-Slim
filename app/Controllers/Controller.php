<?php

namespace App\Controllers;

class Controller {

    protected $container;

    function __construct($container){
            $this->container = $container;
    }

    public function __get($resource){
        if($this->container->{$resource})
        {
            return $this->container->{$resource};
        }

    }
}
