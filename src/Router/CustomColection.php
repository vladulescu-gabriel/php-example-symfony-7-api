<?php

namespace App\Router;

use Symfony\Component\Config\Loader\Loader;
use Symfony\Component\Routing\Loader\Configurator\RouteConfigurator;
use Symfony\Component\Routing\Loader\Configurator\RoutingConfigurator;
use Symfony\Component\Routing\Route;
use Symfony\Component\Routing\RouteCollection;

class CustomColection extends Route
{
    protected $middlewares = [];

    public function middleware($middleware)
    {
        $this->middlewares[] = $middleware;

        return $this;
    }

    public function getMiddlewares()
    {
        return $this->middlewares;
    }
}