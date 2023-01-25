<?php

  namespace BCS\Model\Providers;

  use App\Console\Commands\CheckSQLGrammerDate;

  class BCSModelServiceProvider extends \Illuminate\Support\ServiceProvider
  {
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {

    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        $this->commands([
          CheckSQLGrammerDate::class,
        ]);
    }
  }