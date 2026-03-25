<?php

namespace App\Providers;

use App\Services\BurgerService;
use App\Services\CategoryService;
use App\Services\NotificationService;
use App\Services\OrderService;
use App\Services\PaymentService;
use App\Services\StatService;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        $services = [
            OrderService::class,
            PaymentService::class,
            BurgerService::class,
            CategoryService::class,
            NotificationService::class,
            InvoiceService::class,
            StatService::class,
        ];

        foreach ($services as $service) {
            $this->app->singleton($service);
        }
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        //
    }
}
