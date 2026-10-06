<?php

namespace App\Helpers;

/**
 * String Helper
 * Common string utilities
 */
class StringHelper
{
    /**
     * Highlight search term in text
     */
    public static function highlight(string $text, ?string $search): string
    {
        if (!$search) {
            return htmlspecialchars($text);
        }

        $pattern = preg_quote($search, '/');
        return preg_replace(
            "/$pattern/i",
            '<mark>$0</mark>',
            htmlspecialchars($text)
        );
    }

    /**
     * Truncate text
     */
    public static function truncate(string $text, int $length = 100, string $suffix = '...'): string
    {
        if (strlen($text) <= $length) {
            return $text;
        }
        return substr($text, 0, $length) . $suffix;
    }

    /**
     * Convert to URL-friendly slug
     */
    public static function slug(string $text): string
    {
        $text = strtolower($text);
        $text = preg_replace('/[^a-z0-9]+/', '-', $text);
        return trim($text, '-');
    }
}
