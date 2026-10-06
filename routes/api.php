<?php

use App\Core\Request;
use App\Core\Response;
use App\Core\Router;
use App\Controllers\BikeController;
use App\Controllers\HomeController;
use App\Repositories\BikeRepository;
use App\Services\BikeService;

$request = new Request();
$router = new Router($request);

// Initialize services
$bikeRepository = new BikeRepository();
$bikeService = new BikeService($bikeRepository);

// HTML Routes
$router->get('/', function (Request $req) use ($bikeService) {
    $controller = new HomeController($bikeService);
    $controller->index($req);
});

// API Routes
$router->get('/api/bikes', function (Request $req) use ($bikeService) {
    $controller = new BikeController($bikeService);
    $controller->index($req);
});

$router->get('/api/bikes/{id}', function (Request $req) use ($bikeService) {
    $controller = new BikeController($bikeService);
    // Parse ID from URL if it exists
    $matches = [];
    if (preg_match('/\/api\/bikes\/(\d+)/', $req->getPath(), $matches)) {
        $controller->show($req, (int)$matches[1]);
    }
});

// Handle routing
$result = $router->dispatch();

// If no route matched, check for 404
if ($result === null && !in_array($request->getPath(), ['/', '/api/bikes'])) {
    // Try to match dynamic routes
    $path = $request->getPath();
    
    if (preg_match('/^\/api\/bikes\/(\d+)$/', $path, $matches)) {
        $controller = new BikeController($bikeService);
        $controller->show($request, (int)$matches[1]);
    } else {
        // 404 - Not found
        $response = new Response(404);
        $response->setMessage('Route not found')->json();
    }
}

