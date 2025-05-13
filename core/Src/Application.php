<?php

namespace Src;

use Error;

class Application
{
    private Settings $settings;
    private Route $route;

    public function __construct(Settings $settings)
    {
        $this->settings = $settings;
        $this->route = new Route();
    }

    public function __get($key)
    {
        if ($key === 'settings') {
            return $this->settings;
        }
        throw new Error('Accessing a non-existent property');
    }

    public function run(): void
    {
        $this->route->setPrefix($this->settings->getRootPath());
        $this->route->start();
    }
}