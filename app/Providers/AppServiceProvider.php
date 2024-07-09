<?php

namespace App\Providers;

use Illuminate\Support\Facades\Schema;
use Illuminate\Support\ServiceProvider;

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
      
      	// Increase maximum file size for Algolia index
      	// This is to ensure all files are indexed
      	if (!defined('MAX_FILE_SIZE')) {
          define('MAX_FILE_SIZE', 999999);
        }
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
