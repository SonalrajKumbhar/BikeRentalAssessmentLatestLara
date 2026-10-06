<?php

namespace App\Core;

/**
 * Response Class
 * Handles consistent API responses
 */
class Response
{
    private int $statusCode = 200;
    private bool $success = true;
    private array $data = [];
    private ?string $message = null;
    private ?array $pagination = null;
    private array $errors = [];

    public function __construct(int $statusCode = 200)
    {
        $this->statusCode = $statusCode;
        $this->success = $statusCode >= 200 && $statusCode < 300;
    }

    public function setStatusCode(int $code): self
    {
        $this->statusCode = $code;
        $this->success = $code >= 200 && $code < 300;
        return $this;
    }

    public function setData(array $data): self
    {
        $this->data = $data;
        return $this;
    }

    public function setMessage(string $message): self
    {
        $this->message = $message;
        return $this;
    }

    public function setPagination(array $pagination): self
    {
        $this->pagination = $pagination;
        return $this;
    }

    public function addError(string $field, string $message): self
    {
        $this->errors[$field] = $message;
        return $this;
    }

    public function setErrors(array $errors): self
    {
        $this->errors = $errors;
        return $this;
    }

    /**
     * Send JSON response
     */
    public function json(): void
    {
        header('Content-Type: application/json');
        http_response_code($this->statusCode);

        $response = [
            'success' => $this->success,
            'data' => $this->data,
        ];

        if ($this->message) {
            $response['message'] = $this->message;
        }

        if ($this->pagination) {
            $response['pagination'] = $this->pagination;
        }

        if (!empty($this->errors)) {
            $response['errors'] = $this->errors;
        }

        echo json_encode($response, JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES);
    }

    /**
     * Get response as array
     */
    public function toArray(): array
    {
        return [
            'success' => $this->success,
            'data' => $this->data,
            'message' => $this->message,
            'pagination' => $this->pagination,
            'errors' => $this->errors,
        ];
    }
}
