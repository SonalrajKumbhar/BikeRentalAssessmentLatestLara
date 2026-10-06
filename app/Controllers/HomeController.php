<?php

namespace App\Controllers;

use App\Services\BikeService;
use App\Core\Request;

/**
 * Home Controller
 * Handles HTML views and page rendering
 */
class HomeController
{
    public function __construct(private BikeService $service)
    {
    }

    /**
     * Display bike listing dashboard
     */
    public function index(Request $request): void
    {
        try {
            $params = $request->getPaginationParams();

            $result = $this->service->searchBikes(
                search: $params['search'],
                type: $params['type'],
                minPrice: $params['minPrice'],
                maxPrice: $params['maxPrice'],
                available: $params['available'],
                page: $params['page'],
                perPage: $params['perPage'],
                sortBy: $params['sortBy'],
                sortDir: $params['sortDir']
            );

            $bikes = $result['bikes'];
            $pagination = $result['pagination'];

            // Load view
            require __DIR__ . '/../../views/bikes/index.php';
        } catch (\Exception $e) {
            http_response_code(500);
            echo 'An error occurred: ' . htmlspecialchars($e->getMessage());
        }
    }

    /**
     * Display bike details page
     */
    public function show(Request $request, int $id): void
    {
        try {
            $bike = $this->service->getBikeById($id);

            if (!$bike) {
                http_response_code(404);
                echo '404 - Bike not found';
                return;
            }

            // Load view
            require __DIR__ . '/../../views/bikes/details.php';
        } catch (\Exception $e) {
            http_response_code(500);
            echo 'An error occurred: ' . htmlspecialchars($e->getMessage());
        }
    }
}
