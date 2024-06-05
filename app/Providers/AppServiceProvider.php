<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Pagination\Paginator;
use Laravel\Passport\Console\ClientCommand;
use Laravel\Passport\Console\InstallCommand;
use Laravel\Passport\Console\KeysCommand;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\View;
use Laravel\Passport\Passport;
use Illuminate\Support\Facades\URL;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        Paginator::useBootstrap();
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        if (! function_exists('convertDigitsToBengali')) {
            function convertDigitsToBengali($number) {
                $englishDigits = ['0', '1', '2', '3', '4', '5', '6', '7', '8', '9'];
                $bengaliDigits = ['০', '১', '২', '৩', '৪', '৫', '৬', '৭', '৮', '৯'];

                return str_replace($englishDigits, $bengaliDigits, $number);
            }
        }

        Schema::defaultStringLength(191);
        Passport::routes();
        $this->commands([
            InstallCommand::class,
            ClientCommand::class,
            KeysCommand::class,
        ]);

        View::composer('*', function ($view) {
            $cols = collect(Schema::getColumnListing('settings'))->filter(function ($e) {
                if (!array_search($e, [
                    'short_about',
                    'descriptive_about',
                    'privacy_policy',
                    'terms_condition',
                    'refund_policy',
                    'created_at',
                    'updated_at',
                ])) {
                    return $e;
                }
            })->all();

            $setting = \App\Models\Setting::select($cols)->first();
            $view->with([
                'setting' => $setting,
            ]);
        });

        // View::composer('dashboard.*', function ($view) {
        //     $notifications = Notification::where('user_id',Auth::user()->id)
        //                                 ->orderBy('id','DESC')
        //                                 ->get();
        //     $view->with([
        //         'notifications'=> $notifications,
        //     ]);
        // });

        // Passport::tokensExpireIn(now()->addDays(15));
        // Passport::refreshTokensExpireIn(now()->addDays(30));
        // Passport::personalAccessTokensExpireIn(now()->addMonths(6));
    }
}
