<?php

namespace App\Providers;

use Illuminate\Foundation\Support\Providers\RouteServiceProvider as ServiceProvider;

class RouteServiceProvider extends ServiceProvider
{
    public const HOME = '/profile';

    public function boot(): void
    {
        $this->routes(function () {
            $this->mapWebRoutes();
        });
    }

    protected function mapWebRoutes(): void
    {
        \Illuminate\Support\Facades\Route::middleware('web')
            ->group(base_path('routes/web.php'));
    }
}
