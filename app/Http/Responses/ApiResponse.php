<?php

namespace App\Http\Responses;

use Illuminate\Http\JsonResponse;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Http\Response;

class ApiResponse
{

    /**
     * @param string|null $message
     * @param int $statusCode
     * @param array<string,string>|JsonResource $data
     * @return JsonResponse
     */
    public static function successResponse(string $message = null, int $statusCode = 200, array|JsonResource $data = []) : JsonResponse
    {
        return response()->json([
            'success' => true,
            'data' => $data,
            'message' => $message,
        ], $statusCode);
    }

    /**
     * @param string $message
     * @param int $statusCode
     * @param array<string,string>|JsonResource $data
     * @return JsonResponse
     */
    public static function errorResponse(string $message = "Error",int $statusCode = Response::HTTP_BAD_REQUEST,array|JsonResource $data = [] ) :JsonResponse
    {
        return response()->json([
            'success' => false,
            'message' => $message,
            'errors'=>$data,
        ], $statusCode);
    }






}
