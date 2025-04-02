<?php

namespace Apoliceplano\Providers;

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Vite;
use Illuminate\Support\ServiceProvider;

class ApolicePlanoProvider extends ServiceProvider
{

    public function boot(): void
    {

        Vite::prefetch(concurrency: 3);
        $this->loadViewsFrom(__DIR__ . '/../views/reports', 'apolice.plano');
        // Certifique-se de que o Vite seja configurado para carregar os componentes do Vue.js
        // Usando a função `vite()` para carregar arquivos JS


        \Log::info(date("d-m-Y H:i:s") . " Modulo de Apolice e Plano");
        Route::middleware('web')->group(__DIR__ . '/../routes/web.php');
    }

    public function register(): void
    {

    }
}