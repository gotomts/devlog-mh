<?php

namespace App\Providers\Helper;

use Illuminate\Foundation\AliasLoader;
use Illuminate\Support\ServiceProvider;

class HelperServiceProvider extends ServiceProvider
{
    private $classes;

    public function __construct()
    {
        $this->classes = require __DIR__ . '/HelperList.php';
    }

    /**
     * Register services.
     *
     * @return $class
     */
    public function register()
    {
        foreach ($this->classes as $class) {
            \App::singleton(strtolower($class), function () use ($class) {
                $class = "App\\Services\\Helper\\$class";
                return new $class();
            });
        }
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        foreach ($this->classes as $class) {
            $loader = AliasLoader::getInstance();
            $loader->alias($class, "\\App\\Facades\\Helper\\$class");
        }
    }
}
