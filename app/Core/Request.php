<?php

namespace App\Core;

/**
 * Request Class
 * Handles HTTP request parsing and validation
 */
class Request
{
    private array $query;
    private array $post;
    private array $server;
    private string $method;
    private string $path;

    public function __construct()
    {
        $this->query = $_GET;
        $this->post = $_POST;
        $this->server = $_SERVER;
        $this->method = $this->server['REQUEST_METHOD'] ?? 'GET';
        $this->path = parse_url($this->server['REQUEST_URI'] ?? '', PHP_URL_PATH);
    }

    public function getMethod(): string
    {
        return $this->method;
    }

    public function getPath(): string
    {
        return $this->path;
    }

    public function getQuery(string $key = null, $default = null)
    {
        if ($key === null) {
            return $this->query;
        }
        return $this->query[$key] ?? $default;
    }

    public function getPost(string $key = null, $default = null)
    {
        if ($key === null) {
            return $this->post;
        }
        return $this->post[$key] ?? $default;
    }

    public function getInput(string $key, $default = null)
    {
        return $this->query[$key] ?? $this->post[$key] ?? $default;
    }

    public function all(): array
    {
        return array_merge($this->query, $this->post);
    }

    /**
     * Get query parameters for pagination and filtering
     */
    public function getPaginationParams(): array
    {
        // Helper to safely convert empty string to null for price inputs
        $getPrice = function ($key) {
            $value = $this->getQuery($key);
            // Empty string or null should be treated as null
            return ($value === '' || $value === null) ? null : (float)$value;
        };

        // Helper to safely get type filter (empty string should be null)
        $getType = function () {
            $value = $this->getQuery('type');
            return ($value === '') ? null : $value;
        };

        // Helper to safely get search (empty string should be null)
        $getSearch = function () {
            $value = $this->getQuery('search');
            return ($value === '') ? null : $value;
        };

        return [
            'page' => (int)($this->getQuery('page') ?? 1),
            'perPage' => (int)($this->getQuery('perPage') ?? 10),
            'search' => $getSearch(),
            'type' => $getType(),
            'minPrice' => $getPrice('minPrice'),
            'maxPrice' => $getPrice('maxPrice'),
            'available' => $this->getQuery('available') !== null && $this->getQuery('available') !== '' ? $this->getQuery('available') === 'true' : null,
            'sortBy' => $this->getQuery('sortBy') ?? 'name',
            'sortDir' => $this->getQuery('sortDir') ?? 'asc',
        ];
    }

    /**
     * Validate input
     */
    public function validate(array $rules): array
    {
        $errors = [];
        foreach ($rules as $field => $rule) {
            if ($rule === 'required' && empty($this->getInput($field))) {
                $errors[$field] = ucfirst($field) . ' is required';
            }
        }
        return $errors;
    }
}
