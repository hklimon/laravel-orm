<?php

namespace App\Providers;

use Illuminate\Database\Connection;
use Illuminate\Database\Events\QueryExecuted;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        DB::listen(function (QueryExecuted $query) {
            Log::info('Query execution info '.json_encode($query->sql).' bindings '.json_encode($query->bindings).' time'.json_encode($query->time));
            // $query->sql;
            // $query->bindings;
            // $query->time;
        });

        DB::whenQueryingForLongerThan(1, function (Connection $connection, QueryExecuted $event) {
           Log::info('Query executed time '.json_encode($event->time));
        });

    }
}
