<?php
use App\Http\Controllers\ProductoController;
use Illuminate\Support\Facades\Route;
use Prometheus\CollectorRegistry;
use Prometheus\RenderTextFormat;

Route::middleware([\App\Http\Middleware\PrometheusMiddleware::class])
    ->group(function() {
        Route::apiResource('productos',ProductoController::class);
    });

Route::get('/metrics', function () {
    $registry = app(CollectorRegistry::class);
    $renderer = new RenderTextFormat();
    return response(
        $renderer->render($registry->getMetricFamilySamples()),
        200,
        ['Content-Type' => RenderTextFormat::MIME_TYPE]
    );
});
