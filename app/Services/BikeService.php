<?php

namespace App\Services;

use App\Interfaces\BikeRepositoryInterface;
use App\Models\Bike;

/**
 * Bike Service
 * Business logic for bike operations
 */
class BikeService
{
    public function __construct(private BikeRepositoryInterface $repository)
    {
    }

    /**
     * Get all bikes
     */
    public function getAllBikes(): array
    {
        return $this->repository->all();
    }

    /**
     * Get bike by ID
     */
    public function getBikeById(int $id): ?Bike
    {
        return $this->repository->find($id);
    }

    /**
     * Get bikes with filters, search, sorting, and pagination
     */
    public function searchBikes(
        ?string $search = null,
        ?string $type = null,
        ?float $minPrice = null,
        ?float $maxPrice = null,
        ?bool $available = null,
        int $page = 1,
        int $perPage = 10,
        string $sortBy = 'name',
        string $sortDir = 'asc'
    ): array {
        $query = $this->repository->query();

        // Apply search filter
        if ($search && trim($search) !== '') {
            $query->searchByName($search);
        }

        // Apply type filter
        if ($type && trim($type) !== '') {
            $query->filterByType($type);
        }

        // Apply price range filter only if BOTH prices are provided and valid
        if ($minPrice !== null && $maxPrice !== null && $minPrice >= 0 && $maxPrice >= 0) {
            // Ensure minPrice <= maxPrice
            $actualMinPrice = min($minPrice, $maxPrice);
            $actualMaxPrice = max($minPrice, $maxPrice);
            $query->filterByPriceRange($actualMinPrice, $actualMaxPrice);
        }

        // Apply availability filter
        if ($available !== null) {
            $query->filterByAvailability($available);
        }

        // Apply sorting and pagination
        $query->sortBy($sortBy, $sortDir)
              ->paginate($page, $perPage);

        $results = $query->get();
        $pagination = $query->getPaginationInfo();

        return [
            'bikes' => array_map(fn (Bike $bike) => $bike->toArray(), $results),
            'pagination' => $pagination,
        ];
    }

    /**
     * Get total bike count
     */
    public function getTotalBikes(): int
    {
        return $this->repository->count();
    }
}

