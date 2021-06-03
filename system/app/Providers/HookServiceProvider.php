<?php

namespace App\Providers;

use App\Models\User;
use Illuminate\Support\ServiceProvider;

class HookServiceProvider extends ServiceProvider
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
        User::creating(function($model){ // This function is run while the model is being created.
            //$model->email = 'hook@hook.com';
            // If you want send email before create :)
            return $model;
        });
        User::created(function($model){});
        User::updated(function($model){});
        User::updating(function($model){});
        User::deleted(function($model){});
        User::deleting(function($model){});
        User::saving(function($model){});
        User::saved(function($model){});
    }
}
