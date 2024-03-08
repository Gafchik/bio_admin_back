<?php

namespace App\Providers;

use App\Http\Classes\Core\BaseResponse\BaseResponse;
use App\Http\Classes\Core\BaseResponse\BaseResponseInterface;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //        response
        $this->app->singleton(BaseResponseInterface::class, BaseResponse::class);
        $this->app->singleton('base_response_facade', BaseResponseInterface::class);
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        //
    }
}
