<?php

namespace App\Services;

use Illuminate\Http\JsonResponse;

class UtilityService
{
    /**
     * Generate a standard success response (200) with data.
     *
     * @param string $message
     * @param mixed $data
     * @return JsonResponse
     */
    public function is200ResponseWithData($message, $data): JsonResponse
    {
        return response()->json([
            'status' => 'success',
            'message' => $message,
            'data' => $data
        ], 200);
    }
    public function is200ResponseWith($message): JsonResponse
    {
        return response()->json([
            'status' => 'success',
            'message' => $message,
        ], 200);
    }

    /**
     * Generate a standard created response (201).
     *
     * @param string $message
     * @param mixed $data
     * @return JsonResponse
     */
    public function is201ResponseCreated($message, $data): JsonResponse
    {
        return response()->json([
            'status' => 'success',
            'message' => $message,
            'data' => $data
        ], 201);
    }
    public function is201ResponseUpdated($message,): JsonResponse
    {
        return response()->json([
            'status' => 'success',
            'message' => $message,
        ], 201);
    }

    /**
     * Generate a standard not found response (404).
     *
     * @param string $message
     * @return JsonResponse
     */
    public function is404Response($message): JsonResponse
    {
        return response()->json([
            'status' => 'error',
            'message' => $message,
            'data' => null
        ], 404);
    }

    /**
     * Generate a standard bad request response (400).
     *
     * @param string $message
     * @param mixed $data
     * @return JsonResponse
     */
    public function is400Response($message, $data = null): JsonResponse
    {
        return response()->json([
            'status' => 'error',
            'message' => $message,
            'data' => $data
        ], 400);
    }

    /**
     * Generate an unauthorized response (401).
     *
     * @param string $message
     * @return JsonResponse
     */
    public function is401Unauthorized($message): JsonResponse
    {
        return response()->json([
            'status' => 'error',
            'message' => $message,
            'data' => null
        ], 401);
    }

    /**
     * Generate a forbidden response (403).
     *
     * @param string $message
     * @return JsonResponse
     */
    public function is403Forbidden($message): JsonResponse
    {
        return response()->json([
            'status' => 'error',
            'message' => $message,
            'data' => null
        ], 403);
    }

    /**
     * Generate a not acceptable response (406).
     *
     * @param string $message
     * @return JsonResponse
     */
    public function is406NotAcceptable($message): JsonResponse
    {
        return response()->json([
            'status' => 'error',
            'message' => $message,
            'data' => null
        ], 406);
    }

    /**
     * Generate an internal server error response (500).
     *
     * @param string $message
     * @return JsonResponse
     */
    public function is500InternalServerError($message): JsonResponse
    {
        return response()->json([
            'status' => 'error',
            'message' => $message,
            'data' => null
        ], 500);
    }

    /**
     * Generate a conflict response (409).
     *
     * @param string $message
     * @return JsonResponse
     */
    public function is409Conflict($message): JsonResponse
    {
        return response()->json([
            'status' => 'error',
            'message' => $message,
            'data' => null
        ], 409);
    }

    /**
     * Generate a service unavailable response (503).
     *
     * @param string $message
     * @return JsonResponse
     */
    public function is503ServiceUnavailable($message): JsonResponse
    {
        return response()->json([
            'status' => 'error',
            'message' => $message,
            'data' => null
        ], 503);
    }
}
