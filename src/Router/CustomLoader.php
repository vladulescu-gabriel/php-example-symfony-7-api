<?php

namespace App\Router;

use Symfony\Component\Config\Loader\Loader;
use Symfony\Component\Routing\Loader\Configurator\RouteConfigurator;
use Symfony\Component\Routing\Loader\Configurator\RoutingConfigurator;
use Symfony\Component\Routing\Route;
use Symfony\Component\Routing\RouteCollection;

class CustomLoader
{
    public function load(): RouteConfigurator
    {
        dd("dqwdq");

        // $parentConfigurator = $this instanceof CollectionConfigurator ? $this : ($this instanceof RouteConfigurator ? $this->parentConfigurator : null);
        // $route = $this->createLocalizedRoute($this->collection, $name, $path, $this->name, $this->prefixes);

        // return new RouteConfigurator($this->collection, $route, $this->name, $parentConfigurator, $this->prefixes);
    }

    public function supports(mixed $resource, string|null $type = null): bool 
    {
        return true;
    }
    // private $middleware;
    // private RoutingConfigurator $loader;

    // public function set($routes)
    // {
    //     $this->loader = $routes;
    // }
    
    // public function middleware($middleware)
    // {
    //     parent::middleware() = $this->x();
    //     $this->loader->middleware() = $this->x();
    // }

    // public function x()
    // {

    // }

    public function dqwdq()
    {
        dd("dqwdq");
    }
}