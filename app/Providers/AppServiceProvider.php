<?php

namespace App\Providers;

use Illuminate\Support\Facades\Blade;
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
        /**
         * Generate a badge with associated class
         *
         * Used on grid page, and can be used when iterating through items
         *
         * @param String $expression 'type1', 'type2', or 'type3'
         */
        Blade::directive('itembadge', function ($expression) {

            return "<?php echo '<div class=\"itembadge ' . {$expression} . '\">' . substr({$expression}, 4, 1) . '</div>' ?>";
        });

        /**
         * Fix for: https://github.com/laravel/framework/issues/17508
         *
         * Specify that default string life for MySQL should be 191 characters
         */
        Schema::defaultStringLength(191);
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
