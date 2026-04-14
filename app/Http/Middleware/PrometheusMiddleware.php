<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Prometheus\CollectorRegistry;
class PrometheusMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  Closure(Request): (Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $response = $next($request);
        $registry = app(CollectorRegistry::class);
        $counter = $registry->getOrRegisterCounter(
            'app',
            'http_requests_total',
            'Total de requests HTTP',
            ['method','endpoint','status']
        );
        $counter->inc([
            $request->method(),
            $request->path(),
            $response->getStatusCode()
        ]);
        return $response;
    }
}
