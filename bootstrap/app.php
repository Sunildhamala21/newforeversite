<?php

use App\Http\Middleware\IsAdmin;
use App\Http\Middleware\RedirectWWW;
use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__.'/../routes/web.php',
        commands: __DIR__.'/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware) {
        $middleware->alias([
            'admin' => IsAdmin::class,
            'minify' => \Abordage\LaravelHtmlMin\Middleware\HtmlMinify::class,
        ]);
        $middleware->redirectUsersTo('/admin/dashboard');
        $middleware->encryptCookies(['cookie_consent']);
        $middleware->appendToGroup('web', [
            // RedirectWWW::class,
        ]);
    })
    ->withExceptions(function (Exceptions $exceptions) {
        $exceptions->context(fn () => ['url' => request()->url()]);
    })->create();
