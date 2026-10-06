<?php

namespace App\Interfaces;

/**
 * Bike Repository Interface
 * Defines contract for bike data access
 */
interface BikeRepositoryInterface
{
    /**
     * Get all bikes
     */
    public function all(): array;

    /**
     * Get bike by ID
     */
    public function find(int $id): ?\App\Models\Bike;

    /**
     * Get bikes with filters, search, sorting, and pagination
     */
    public function query(): BikeQueryBuilder;

    /**
     * Get total count of bikes
     */
    public function count(): int;
}

