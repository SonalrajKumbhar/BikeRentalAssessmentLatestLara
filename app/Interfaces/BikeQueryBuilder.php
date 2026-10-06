<?php

namespace App\Interfaces;

/**
 * Bike Query Builder Interface
 * Defines contract for building bike queries
 */
interface BikeQueryBuilder
{
    /**
     * Filter by bike type
     */
    public function filterByType(string $type): self;

    /**
     * Filter by availability
     */
    public function filterByAvailability(bool $available): self;

    /**
     * Filter by price range
     */
    public function filterByPriceRange(float $minPrice, float $maxPrice): self;

    /**
     * Search by name
     */
    public function searchByName(string $term): self;

    /**
     * Sort results
     */
    public function sortBy(string $column, string $direction = 'asc'): self;

    /**
     * Paginate results
     */
    public function paginate(int $page, int $perPage): self;

    /**
     * Get results
     */
    public function get(): array;

    /**
     * Get total count (before pagination)
     */
    public function count(): int;

    /**
     * Get pagination info
     */
    public function getPaginationInfo(): array;
}
