<?php

namespace App\Helpers;

/**
 * Pagination Helper
 * Calculates pagination data
 */
class PaginationHelper
{
    /**
     * Calculate pagination data
     */
    public static function paginate(int $total, int $page, int $perPage): array
    {
        $totalPages = (int)ceil($total / $perPage);
        $page = max(1, min($page, $totalPages));
        $offset = ($page - 1) * $perPage;

        return [
            'current_page' => $page,
            'per_page' => $perPage,
            'total' => $total,
            'total_pages' => $totalPages,
            'offset' => $offset,
            'has_previous' => $page > 1,
            'has_next' => $page < $totalPages,
            'previous_page' => $page > 1 ? $page - 1 : null,
            'next_page' => $page < $totalPages ? $page + 1 : null,
        ];
    }

    /**
     * Get page numbers for display
     */
    public static function getPageNumbers(int $page, int $totalPages, int $range = 5): array
    {
        $pages = [];
        $start = max(1, $page - (int)floor($range / 2));
        $end = min($totalPages, $start + $range - 1);
        $start = max(1, $end - $range + 1);

        for ($i = $start; $i <= $end; $i++) {
            $pages[] = $i;
        }

        return $pages;
    }
}
