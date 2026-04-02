<?php

use App\Support\HttpErrors;
use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;
use Illuminate\Auth\AuthenticationException;
use Symfony\Component\HttpKernel\Exception\HttpExceptionInterface;
use App\Http\Middleware\AdminOrEditor;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__.'/../routes/web.php',
        api: __DIR__.'/../routes/api.php',
        commands: __DIR__.'/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware): void {
        $middleware->alias([
            'admin.editor' => AdminOrEditor::class,
        ]);
    })
    ->withExceptions(function (Exceptions $exceptions): void {
        $exceptions->render(function (AuthenticationException $e, $request) {
            if (!$request->expectsJson()) {
                return redirect()->route('login');
            }

            $code    = 401;
            $error   = HttpErrors::get($code);
            $title       = $error['title'];
            $description = $error['description'];
            $headers     = HttpErrors::responseHeaders($code, ['WWW-Authenticate' => 'Bearer realm="app"']);

            return response(
                view('errors.http', compact('code', 'title', 'description', 'headers')),
                $code,
                $headers
            );
        });

        $exceptions->render(function (HttpExceptionInterface $e) {
            $code  = $e->getStatusCode();
            $error = HttpErrors::get($code);

            // Для кодов, которых нет в нашем справочнике, используем заголовки из исключения
            $title       = $error['title']       ?? 'Error';
            $description = $error['description'] ?? $e->getMessage() ?: 'Произошла ошибка.';
            $headers     = HttpErrors::responseHeaders($code, $e->getHeaders());

            return response(
                view('errors.http', compact('code', 'title', 'description', 'headers')),
                $code,
                $headers
            );
        });
    })->create();
