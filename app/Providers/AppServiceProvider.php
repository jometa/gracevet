<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Schema;
use App\Services\DefaultProps;
use App\Services\UserFac;
use App\RekamMedik;
use App\Observers\RekamMedikObserver;
use App\Observers\JenisHewanRMObserver;
use App\Observers\PenKhususRMObserver;

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
        Schema::defaultStringLength(191);
        RekamMedik::observe(RekamMedikObserver::class);
        RekamMedik::observe(JenisHewanRMObserver::class);
        RekamMedik::observe(PenKhususRMObserver::class);
    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
        $defProps = new DefaultProps();
        $userFac = new UserFac();
        $this->app->instance('App\Services\DefaultProps', $defProps);
        $this->app->instance('App\Services\UserFac', $userFac);
    }
}
