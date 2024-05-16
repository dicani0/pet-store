<?php

namespace App\Providers;

use App\Clients\Contracts\PetStoreClientContract;
use App\Clients\PetStoreStoreClient;
use App\Services\Contracts\PetServiceContract;
use App\Services\PetService;
use Illuminate\Support\ServiceProvider;

class PetStoreProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        $this->app->bind(
            PetServiceContract::class,
            PetService::class
        );

        $this->app->bind(
            PetStoreClientContract::class,
            PetStoreStoreClient::class
        );
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        //
    }
}
