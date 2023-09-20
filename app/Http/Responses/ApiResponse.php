<?php

namespace App\Http\Responses;

use Illuminate\Http\Response;

class ApiResponse
{

    public static function successResponse($message = null, $statusCode = 200,$data = [])
    {
        return response()->json([
            'success' => true,
            'data' => $data,
            'message' => $message,
        ], $statusCode);
    }

    public static function errorResponse($message = "Error",$statusCode = Response::HTTP_BAD_REQUEST, $data = [] )
    {
        return response()->json([
            'success' => false,
            'message' => $message,
            'errors'=>$data,
        ], $statusCode);
    }






}
