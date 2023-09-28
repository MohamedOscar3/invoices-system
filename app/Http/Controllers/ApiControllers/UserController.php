<?php

namespace App\Http\Controllers\ApiControllers;

use App\Http\Controllers\Controller;
use App\Http\Resources\UserResource;
use App\Http\Responses\ApiResponse;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;


class UserController extends Controller
{
    public function check(Request $request) : JsonResponse
    {

        $user = auth()->user();
        if ($user != null) {
            $token = $request->bearerToken();
            $user->token = $token;
            return ApiResponse::successResponse("",200,new UserResource($user));
        } else {
            return ApiResponse::errorResponse("Token expired !",401,[]);
        }

    }
}
