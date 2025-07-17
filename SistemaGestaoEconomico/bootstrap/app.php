<?php

use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__ . '/../routes/web.php',
        commands: __DIR__ . '/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware): void {
        $middleware->validateCsrfTokens(except: [
            'http://localhost:8080/grupoEconomico',
            'http://localhost:8080/bandeira',
            'http://localhost:8080/bandeiras',
            'http://localhost:8080/unidades',
            'http://localhost:8080/colaborador'
        ]);
    })
    ->withExceptions(function (Exceptions $exceptions): void {
        //
    })->create();
