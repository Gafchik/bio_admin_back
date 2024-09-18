<?php

namespace App\Providers;

use App\Http\Classes\Core\Archive\Archive;
use App\Http\Classes\Core\Archive\ArchiveInterface;
use App\Http\Classes\Core\BaseResponse\BaseResponse;
use App\Http\Classes\Core\BaseResponse\BaseResponseInterface;

use App\Http\Classes\Core\Pdf\PdfGenerator;
use App\Http\Classes\Core\Pdf\PdfGeneratorInterface;
use App\Http\Classes\LogicalModels\Common\UserInfo\UserInfo;
use App\Http\Classes\LogicalModels\Common\UserInfo\UserInfoInterface;
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
        //      user info
        $this->app->singleton(UserInfoInterface::class, UserInfo::class);
        $this->app->singleton('user_info_facade', UserInfoInterface::class);
        //        pdf
        $this->app->singleton(PdfGeneratorInterface::class, PdfGenerator::class);
        $this->app->singleton('pdf_facade', PdfGeneratorInterface::class);
//        archive_facade
        $this->app->singleton(ArchiveInterface::class, Archive::class);
        $this->app->singleton('archive_facade', ArchiveInterface::class);
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        //
    }
}
