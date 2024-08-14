<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Aws\DynamoDb\DynamoDbClient;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        $this->app->singleton(DynamoDbClient::class, function ($app) {
            return new DynamoDbClient([
                'region' => env('AWS_DEFAULT_REGION', 'ap-southeast-1'),
                'version' => 'latest',
                'credentials' => [
                    'key' > env('AWS_ACCESS_KEY_ID', 'migoyLocalAccess'),
                    'secret' => env('AWS_SECRET_ACCESS_KEY', 'migoyLocalSecret'),
                ],
                'endpoint' => env('AWS_DYNAMODB_ENDPOINT', 'http://localhost:8002'),
            ]);
        });
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        //
    }
}
