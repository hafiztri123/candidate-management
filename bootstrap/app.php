<?php

use App\Shared\Exceptions\DomainException;
use App\Shared\Services\ApiResponderService;
use Illuminate\Auth\AuthenticationException;
use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Session\Middleware\StartSession;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__.'/../routes/web.php',
        api: __DIR__.'/../routes/api.php',
        commands: __DIR__.'/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware) {
        $middleware->statefulApi();
        $middleware->append(StartSession::class);


    })
    ->withExceptions(function (Exceptions $exceptions) {
        $exceptions->render(function (DomainException $e, Request $request){
            return (new ApiResponderService)->errorResponse($e->getCustomMessage(), $e->getHttpCode(), [
                'exception' => get_class($e),
                'errors' => $e->getErrors()
            ]);
        });

        $exceptions->render(function (AuthenticationException $e, Request $request) {
            return (new ApiResponderService)->errorResponse(
                $e->getMessage(),
                Response::HTTP_UNAUTHORIZED
            );
        });

        $exceptions->render(function (Exception $e, Request $request) {
            $debugInfo = env('APP_DEBUG', false)
                ? [
                    'file' => $e->getFile(),
                    'line' => $e->getLine(),
                    'trace' => $e->getTrace(),
                    'exception' => get_class($e),
                ]
                : ['info' => 'Debug has been disabled'];

            return (new ApiResponderService)->errorResponse(
                $e->getMessage(),
                $e->getCode() ?: Response::HTTP_INTERNAL_SERVER_ERROR,
                $debugInfo
            );


    });
})->create();
