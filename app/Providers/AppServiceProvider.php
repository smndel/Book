<?php

namespace App\Providers;

use App\Score;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\Validator;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        Schema::defaultStringLength(191);

        //$value sera le book_id
        //$parameters sera l'adresse ip

        //Cette classe permettra de vérifier un vote par livre par adresse IP
        Validator::extend('uniqueVoteIp', function($attribute, $value, $parameters, $validator){
           $totalIp = Score::where('book_id', $value)->where('ip', $parameters[0])->count();

           if($totalIp==0){
            return true; 

           }else{
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
        //
    }
}
