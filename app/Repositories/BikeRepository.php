<?php

namespace App\Repositories;

use App\Interfaces\BikeRepositoryInterface;
use App\Interfaces\BikeQueryBuilder;
use App\Models\Bike;

/**
 * Bike Repository
 * Handles bike data access and queries
 */
class BikeRepository implements BikeRepositoryInterface
{
    private array $bikes = [];

    public function __construct()
    {
        $this->bikes = $this->initializeBikes();
    }

    /**
     * Get all bikes
     */
    public function all(): array
    {
        return $this->bikes;
    }

    /**
     * Find bike by ID
     */
    public function find(int $id): ?Bike
    {
        foreach ($this->bikes as $bike) {
            if ($bike->getId() === $id) {
                return $bike;
            }
        }
        return null;
    }

    /**
     * Get query builder
     */
    public function query(): BikeQueryBuilder
    {
        return new BikeQueryBuilderImpl($this->bikes);
    }

    /**
     * Get total count
     */
    public function count(): int
    {
        return count($this->bikes);
    }

    /**
     * Initialize bikes data
     * In production, this would load from a database
     */
    private function initializeBikes(): array
    {
        return [
            new Bike(1, 'Trek X-Caliber', 'mountain', 45.99, true, 'High-performance hardtail mountain bike', null),
            new Bike(2, 'Giant Talon 29', 'mountain', 52.50, true, 'Aggressive hardtail for trail riding', null),
            new Bike(3, 'Specialized Rockhopper', 'mountain', 38.75, true, 'Beginner-friendly mountain bike', null),
            new Bike(4, 'Trek FX 3', 'hybrid', 28.99, true, 'Versatile hybrid for casual rides', null),
            new Bike(5, 'Giant Escape 3', 'hybrid', 32.00, true, 'Comfortable commuter hybrid bike', null),
            new Bike(6, 'Trek Domane AL', 'road', 55.00, false, 'Smooth-riding endurance road bike', null),
            new Bike(7, 'Specialized Allez', 'road', 48.00, true, 'Entry-level road bike with aluminum frame', null),
            new Bike(8, 'Huffy Comfort Cruiser', 'cruiser', 18.50, true, 'Classic beach cruiser for relaxed riding', null),
            new Bike(9, 'Schwinn Mikado', 'cruiser', 22.00, true, 'Stylish cruiser with comfortable seating', null),
            new Bike(10, 'Sunday Soundwave', 'bmx', 24.99, true, 'Lightweight BMX bike for tricks', null),
            new Bike(11, 'Fit Series One', 'bmx', 28.50, false, 'Professional BMX competition bike', null),
            new Bike(12, 'Rad Ventures Electric', 'electric', 85.00, true, 'Electric bike for effortless commuting', null),
            new Bike(13, 'Trek Powerfly', 'electric', 95.99, true, 'High-powered electric mountain bike', null),
            new Bike(14, 'Specialized Epic', 'mountain', 72.00, true, 'Cross-country race mountain bike', null),
            new Bike(15, 'Cannondale Quick', 'hybrid', 35.00, true, 'Fast and agile hybrid bike', null),
        ];
    }
}

/**
 * Bike Query Builder Implementation
 * Builds complex queries with filters, search, sort, and pagination
 */
class BikeQueryBuilderImpl implements BikeQueryBuilder
{
    private array $bikes;
    private array $filtered = [];
    private string $sortColumn = 'name';
    private string $sortDirection = 'asc';
    private int $page = 1;
    private int $perPage = 10;
    private int $total = 0;
    private array $paginationInfo = [];

    public function __construct(array $bikes)
    {
        $this->bikes = $bikes;
        $this->filtered = $bikes;
        $this->total = count($bikes);
    }

    /**
     * Filter by bike type
     */
    public function filterByType(string $type): self
    {
        $this->filtered = array_filter($this->filtered, function (Bike $bike) use ($type) {
            return strtolower($bike->getType()) === strtolower($type);
        });
        return $this;
    }

    /**
     * Filter by availability
     */
    public function filterByAvailability(bool $available): self
    {
        $this->filtered = array_filter($this->filtered, function (Bike $bike) use ($available) {
            return $bike->isAvailable() === $available;
        });
        return $this;
    }

    /**
     * Filter by price range
     */
    public function filterByPriceRange(float $minPrice, float $maxPrice): self
    {
        // Ensure min <= max
        $min = min($minPrice, $maxPrice);
        $max = max($minPrice, $maxPrice);

        $this->filtered = array_filter($this->filtered, function (Bike $bike) use ($min, $max) {
            $price = $bike->getPrice();
            return $price >= $min && $price <= $max;
        });
        return $this;
    }

    /**
     * Search by name
     */
    public function searchByName(string $term): self
    {
        $search = strtolower($term);
        $this->filtered = array_filter($this->filtered, function (Bike $bike) use ($search) {
            return str_contains(strtolower($bike->getName()), $search) ||
                   str_contains(strtolower($bike->getType()), $search) ||
                   str_contains(strtolower($bike->getDescription()), $search);
        });
        return $this;
    }

    /**
     * Sort results
     */
    public function sortBy(string $column, string $direction = 'asc'): self
    {
        $this->sortColumn = $column;
        $this->sortDirection = strtolower($direction);
        return $this;
    }

    /**
     * Paginate results
     */
    public function paginate(int $page, int $perPage): self
    {
        $this->page = max(1, $page);
        $this->perPage = max(1, $perPage);
        return $this;
    }

    /**
     * Get results
     */
    public function get(): array
    {
        $this->total = count($this->filtered);

        // Sort
        $this->sortResults();

        // Paginate
        $offset = ($this->page - 1) * $this->perPage;
        $paginated = array_slice($this->filtered, $offset, $this->perPage);

        // Calculate pagination info
        $this->paginationInfo = [
            'current_page' => $this->page,
            'per_page' => $this->perPage,
            'total' => $this->total,
            'total_pages' => (int)ceil($this->total / $this->perPage),
            'offset' => $offset,
            'has_previous' => $this->page > 1,
            'has_next' => $this->page < (int)ceil($this->total / $this->perPage),
        ];

        return array_values($paginated);
    }

    /**
     * Count results (before pagination)
     */
    public function count(): int
    {
        return $this->total;
    }

    /**
     * Get pagination info
     */
    public function getPaginationInfo(): array
    {
        return $this->paginationInfo;
    }

    /**
     * Sort results
     */
    private function sortResults(): void
    {
        usort($this->filtered, function (Bike $a, Bike $b) {
            $aValue = match ($this->sortColumn) {
                'price' => $a->getPrice(),
                'type' => $a->getType(),
                default => $a->getName(),
            };

            $bValue = match ($this->sortColumn) {
                'price' => $b->getPrice(),
                'type' => $b->getType(),
                default => $b->getName(),
            };

            $result = $aValue <=> $bValue;
            return $this->sortDirection === 'desc' ? -$result : $result;
        });
    }
}

