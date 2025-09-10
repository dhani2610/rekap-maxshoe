<?php

namespace App\Providers;

use Carbon\Carbon;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Blade;
use Google\Client;
use Google\Service\Sheets as GoogleSheets;
use Revolution\Google\Sheets\Sheets;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->singleton(GoogleSheets::class, function ($app) {
            $client = new Client();
            $client->setApplicationName(config('google.application_name'));
            $client->setScopes([GoogleSheets::SPREADSHEETS]);
            $client->setAuthConfig(storage_path('credentials.json'));
            $client->setAccessType('offline');

            return new GoogleSheets($client);
        });

        $this->app->singleton(Sheets::class, function ($app) {
            return new Sheets($app->make(GoogleSheets::class));
        });
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {

        if (env('APP_ENV') === 'local' && request()->server('HTTP_X_FORWARDED_PROTO') === 'https') {
            URL::forceScheme('https');
        }
        config(['app.locale' => 'id']);
        Carbon::setLocale('id');
        date_default_timezone_set('Asia/Jakarta');

        Blade::directive('currency', function ($expression) {
            return "Rp. <?php echo number_format($expression,0,',','.'); ?>";
        });

        if (env('REDIRECT_HTTPS')) {
            URL::forceScheme('https');
        }
    }
}
