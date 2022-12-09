<?php

namespace App\Providers;

use App\Repositories\DespesasRepository;
use App\Repositories\EloquentDespesaRepository;
use Illuminate\Support\ServiceProvider;

class DespesaRepositoryProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->bind(DespesasRepository::class, EloquentDespesaRepository::class);
    }
}
