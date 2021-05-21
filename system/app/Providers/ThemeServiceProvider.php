<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

class ThemeServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        $getConfigThemeName = config('app.theme') === 'default' ?
            'views' : config('app.theme');
        if ($getConfigThemeName === 'views') {
            $views = resource_path('views');
        } else {
            $views = [
                'themes/' . $getConfigThemeName,
                //resource_path('views')
            ];

        }



        $this->loadViewsFrom($views, 'theme');
    }
}
