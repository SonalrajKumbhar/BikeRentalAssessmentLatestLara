<?php

namespace App\Helpers;

/**
 * Validation Helper
 * Common validation utilities
 */
class ValidationHelper
{
    /**
     * Validate price range
     */
    public static function validatePriceRange(?float $minPrice, ?float $maxPrice): bool
    {
        if ($minPrice !== null && $minPrice < 0) {
            return false;
        }
        if ($maxPrice !== null && $maxPrice < 0) {
            return false;
        }
        if ($minPrice !== null && $maxPrice !== null && $minPrice > $maxPrice) {
            return false;
        }
        return true;
    }

    /**
     * Validate page number
     */
    public static function validatePage(int $page): bool
    {
        return $page > 0;
    }

    /**
     * Validate per page
     */
    public static function validatePerPage(int $perPage, int $maxPerPage = 100): bool
    {
        return $perPage > 0 && $perPage <= $maxPerPage;
    }

    /**
     * Sanitize string input
     */
    public static function sanitize(string $input): string
    {
        return trim(htmlspecialchars($input, ENT_QUOTES, 'UTF-8'));
    }
}
