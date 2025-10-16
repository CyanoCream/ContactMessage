<?php

namespace App\Providers;

use App\Repositories\ContactMessageRepository;
use App\Repositories\Contracts\ContactMessageRepositoryInterface;
use App\UseCases\ContactMessageUseCase;
use App\UseCases\Contracts\ContactMessageUseCaseInterface;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        // Repository Bindings
        $this->app->bind(ContactMessageRepositoryInterface::class, ContactMessageRepository::class);

        // Use Case Bindings
        $this->app->bind(ContactMessageUseCaseInterface::class, ContactMessageUseCase::class);
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        //
    }
}
