<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Response;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        //
        Response::macro('phpfiledownload', function ($content) {

            $headers = [
                'Content-type'        => 'text/x-php',
                'Content-Disposition' => 'attachment; filename="download.php"',
            ];

            return Response::make($content, 200, $headers);
        });
    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }
}
