<?php

namespace App\Providers;

use Illuminate\Support\Facades\Broadcast;
use Illuminate\Support\ServiceProvider;


class BroadcastServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        Broadcast::routes();
        // Mail::extend('sendinblue', function () {
        //     return (new SendinblueTransportFactory)->create(
        //         new Dsn(
        //             'sendinblue+api',
        //             'default',
        //             config('services.sendinblue.key')
        //         )
        //     );
        // });

        require base_path('routes/channels.php');
    }
}
