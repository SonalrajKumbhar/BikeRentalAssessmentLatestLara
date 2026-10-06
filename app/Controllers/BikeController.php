<?php

namespace App\Controllers;

use App\Services\BikeService;
use App\Core\Request;
use App\Core\Response;
use App\Helpers\ValidationHelper;

/**
 * Bike API Controller
 * Handles API endpoints for bike data
 */
class BikeController
{
    public function __construct(private BikeService $service)
    {
    }

    /**
     * Get bikes list with filtering, search, and pagination
     */
    public function index(Request $request): void
    {
        try {
            $params = $request->getPaginationParams();

            // Validate pagination parameters
            if (!ValidationHelper::validatePage($params['page'])) {
                $response = new Response(400);
                $response->setMessage('Invalid page number')
                        ->addError('page', 'Page must be greater than 0')
                        ->json();
                return;
            }

            if (!ValidationHelper::validatePerPage($params['perPage'])) {
                $response = new Response(400);
                $response->setMessage('Invalid per page value')
                        ->addError('perPage', 'Per page must be between 1 and 100')
                        ->json();
                return;
            }

            if (!ValidationHelper::validatePriceRange($params['minPrice'], $params['maxPrice'])) {
                $response = new Response(400);
                $response->setMessage('Invalid price range')
                        ->addError('price', 'Price range is invalid')
                        ->json();
                return;
            }

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

            $response = new Response(200);
            $response->setData($result['bikes'])
                    ->setPagination($result['pagination'])
                    ->json();
        } catch (\Exception $e) {
            $response = new Response(500);
            $response->setMessage('Internal server error')
                    ->addError('error', $e->getMessage())
                    ->json();
        }
    }

    /**
     * Get single bike by ID
     */
    public function show(Request $request, int $id): void
    {
        try {
            $bike = $this->service->getBikeById($id);

            if (!$bike) {
                $response = new Response(404);
                $response->setMessage('Bike not found')
                        ->json();
                return;
            }

            $response = new Response(200);
            $response->setData([$bike->toArray()])
                    ->json();
        } catch (\Exception $e) {
            $response = new Response(500);
            $response->setMessage('Internal server error')
                    ->addError('error', $e->getMessage())
                    ->json();
        }
    }
}

