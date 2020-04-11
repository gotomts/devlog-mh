<?php

namespace App\Providers\ViewHelper;

use Illuminate\Foundation\AliasLoader;
use Illuminate\Support\ServiceProvider;

class ViewHelperServiceProvider extends ServiceProvider
{
    private $classes;

    public function __construct()
    {
        $this->classes = require __DIR__ . '/ViewHelperList.php';
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
                $class = "App\\Services\\ViewHelper\\$class";
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
            $loader->alias($class, "\\App\\Facades\\ViewHelper\\$class");
        }
    }
}
