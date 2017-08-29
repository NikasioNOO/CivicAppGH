<?php

namespace CivicApp\Http;

use Illuminate\Foundation\Http\Kernel as HttpKernel;

class Kernel extends HttpKernel
{
    /**
     * The application's global HTTP middleware stack.
     *
     * These middleware are run during every request to your application.
     *
     * @var array
     */
    protected $middleware = [
        \Illuminate\Foundation\Http\Middleware\CheckForMaintenanceMode::class,
      //  \CivicApp\Http\Middleware\EncryptCookies::class,
      //  \Illuminate\Cookie\Middleware\AddQueuedCookiesToResponse::class,
      //  \Illuminate\Session\Middleware\StartSession::class,
      //  \Illuminate\View\Middleware\ShareErrorsFromSession::class,
      //  \CivicApp\Http\Middleware\VerifyCsrfToken::class,
    ];

    /**
     * The application's route middleware groups.
     *
     * @var array
     */
    protected $middlewareGroups = [
        'web' => [
            \CivicApp\Http\Middleware\EncryptCookies::class,
            \Illuminate\Cookie\Middleware\AddQueuedCookiesToResponse::class,
            \Illuminate\Session\Middleware\StartSession::class,
            \Illuminate\View\Middleware\ShareErrorsFromSession::class,
            \CivicApp\Http\Middleware\VerifyCsrfToken::class,
            \Illuminate\Routing\Middleware\SubstituteBindings::class, /* upgrade 5.3 */
        ],

        'api' => [
            'throttle:60,1',
            'bindings',
        ],
    ];

    /**
     * The application's route middleware.
     *
     * @var array
     */
    protected $routeMiddleware = [
        'auth' => \CivicApp\Http\Middleware\Authenticate::class,
        'auth.basic' => \Illuminate\Auth\Middleware\AuthenticateWithBasicAuth::class,
        'guest' => \CivicApp\Http\Middleware\RedirectIfAuthenticated::class,
        'throttle' => \Illuminate\Routing\Middleware\ThrottleRequests::class,
        'can' => \Illuminate\Auth\Middleware\Authorize::class, /* upgrade 5.3 */
        'bindings' => \Illuminate\Routing\Middleware\SubstituteBindings::class, /* upgrade 5.3 */
    ];
}
