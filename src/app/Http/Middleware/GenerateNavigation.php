<?php

namespace App\Http\Middleware;

use App\Models\Category;
use Closure;
use Illuminate\View\Factory;

class GenerateNavigation
{
    public function __construct(Factory $viewFactory)
    {
        $this->viewFactory = $viewFactory;
    }

    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        $category = Category::getPostCategory();
        $this->viewFactory->share('navItems', $category);
        return $next($request);
    }
}
