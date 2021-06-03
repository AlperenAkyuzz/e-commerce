<?php


namespace App\Providers;

namespace App\Providers;

use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Str;


class TranslationServiceProvider extends ServiceProvider
{
    /**
     * The path to the current lang files.
     *
     * @var string
     */
    protected $langPath;

    /**
     * Create a new service provider instance.
     *
     * @return void
     */
    public function __construct()
    {
        $lang = App::getLocale();
        if (Str::length($lang) > 2) {
            $this->langPath = resource_path('lang/tr');
        } else {
            $this->langPath = resource_path('lang/' . App::getLocale());
        }

    }

    /**
     * Bootstrap the application services.
     *
     * @return void
     */
    public function boot()
    {
        //dd($this->langPath);
        Cache::rememberForever('translations', function () {
            return collect(File::allFiles($this->langPath))->flatMap(function ($file) {
                return [
                    ($translation = $file->getBasename('.php')) => trans($translation),
                ];
            })->toJson();
        });

    }
}
