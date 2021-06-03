<?php

namespace App\Providers;

use App;
use Illuminate\Support\Facades\Event;
use Illuminate\Support\Facades\Validator;
use Session;
use App\Models\User;
use App\Models\Category;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\ServiceProvider;
use Illuminate\Pagination\Paginator;
use Illuminate\Pagination\LengthAwarePaginator;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {

        setlocale(LC_TIME, 'Turkish');
        if (env('APP_ENV') !== 'production') {
            DB::connection()->enableQueryLog();
            Event::listen('kernel.handled', function ($request, $response) {
                if ( $request->has('debug') ) {
                    $queries = DB::getQueryLog();
                    $formattedQueries = [];
                    foreach( $queries as $query ) :
                        $prep = $query['query'];
                        foreach( $query['bindings'] as $binding ) :
                            $prep = preg_replace("#\?#", is_numeric($binding) ? $binding : "'" . $binding . "'", $prep, 1);
                        endforeach;
                        $formattedQueries[] = $this->removeLineBreaks($prep);
                    endforeach;
                    dd($formattedQueries);
                }
            });
        }

        Paginator::useBootstrap();

        $admin_lang = DB::table('admin_languages')->where('is_default','=',1)->first();
        App::setlocale($admin_lang->name);
        User::chekValidation();

        $general_settings = DB::table('generalsettings')->first();

        /** Set Mail Configuration */
        if($general_settings->header_email == 'smtp') {
            $mail_driver = 'smtp';
        }
        else{
            if($general_settings->header_email == 'sendmail') {
                $mail_driver = 'sendmail';
            }
            else {
                $mail_driver = 'smtp';
            }
        }
        \Config::set('mail.driver', $mail_driver);
        \Config::set('mail.host', $general_settings->smtp_host);
        \Config::set('mail.port', $general_settings->smtp_port);
        \Config::set('mail.encryption', $general_settings->email_encryption);
        \Config::set('mail.username', $general_settings->smtp_user);
        \Config::set('mail.password', $general_settings->smtp_pass);
        /** End Mail Configuration */

        view()->composer('*',function($settings) use ($general_settings) {

            $settings->with('gs', cache()->remember('generalsettings', now()->addDay(), function () use ($general_settings) {
                return $general_settings;
            }));

            $settings->with('ps', cache()->remember('pagesettings', now()->addDay(), function () {
                return DB::table('pagesettings')->first();
            }));

            $settings->with('seo', cache()->remember('seotools', now()->addDay(), function () {
                return DB::table('seotools')->first();
            }));

            $settings->with('socialsetting', cache()->remember('socialsettings', now()->addDay(), function () {
                return DB::table('socialsettings')->first();
            }));

            // Category Cache
            $settings->with('categories', cache()->remember('categories', now()->addDay(), function () {
                return Category::with('subs')->where('status','=',1)->get();
            }));

            // Language Session
            if (Session::has('language')){
                $data = cache()->remember('session_language', now()->addDay(), function () {
                    return DB::table('languages')->find(Session::get('language'));
                });
                $data_results = file_get_contents(public_path().'/assets/languages/'.$data->file);
                $lang = json_decode($data_results);
                $settings->with('langg', $lang);
            }
            else{
                $data = cache()->remember('default_language', now()->addDay(), function () {
                    return DB::table('languages')->where('is_default','=',1)->first();
                });
                $data_results = file_get_contents(public_path().'/assets/languages/'.$data->file);
                $lang = json_decode($data_results);
                $settings->with('langg', $lang);
            }

            if (!Session::has('popup'))
            {
                $settings->with('visited', 1);
            }

            Session::put('popup' , 1);

        });

        Validator::extend('recaptcha', function ($attribute, $value, $parameters, $validator) use ($general_settings) {
            $recaptcha3url =  'https://www.google.com/recaptcha/api/siteverify?secret=' . urlencode($general_settings->recaptcha_secret) .  '&response=' . urlencode($value);

            $response = file_get_contents($recaptcha3url);
            $responseKeys = json_decode($response, true);

            //var_dump($responseKeys);
            if($responseKeys["success"]) {
                return true;
            } else {
                return false;
            }
        });
    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {

        Collection::macro('paginate', function($perPage, $total = null, $page = null, $pageName = 'page') {
            $page = $page ?: LengthAwarePaginator::resolveCurrentPage($pageName);
            return new LengthAwarePaginator(
                $this->forPage($page, $perPage),
                $total ?: $this->count(),
                $perPage,
                $page,
                [
                    'path' => LengthAwarePaginator::resolveCurrentPath(),
                    'pageName' => $pageName,
                ]
            );
        });

    }

    private function defineHooks() {
        User::created(function($model){
            // when user created this function running
        });
    }

    /***
     * @param string $item
     * @return string|string[]
     */
    function removeLineBreaks(string $item){
        return str_replace(["\r\n", "\r", "\n"], ' ', $item);
    }
}
