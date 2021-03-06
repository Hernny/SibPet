<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Auth0\Login\Contract\Auth0UserRepository as Auth0UserRepositoryContract;
use Auth0\Login\Repository\Auth0UserRepository as Auth0UserRepository;
use App\Repository\Auth0CustomUserRepository as Auth0CustomUserRepository;
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
    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->bind( 
        Auth0UserRepositoryContract::class,
        Auth0CustomUserRepository::class);

        // This is used for RS256 tokens to avoid fetching the JWKs on each request
        $this->app->bind(
            '\Auth0\SDK\Helpers\Cache\CacheHandler',
            function() {
                static $cacheWrapper = null; 
                if ($cacheWrapper === null) {
                    $cache = Cache::store();
                    $cacheWrapper = new LaravelCacheWrapper($cache);
                }
                return $cacheWrapper;
            });
    }

}
