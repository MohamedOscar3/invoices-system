<?php

namespace App\Http\Controllers\ApiControllers\Auth;



use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use App\Http\Resources\UserResource;
use App\Http\Responses\ApiResponse;
use App\Models\User;
use \Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class LoginController extends Controller
{

    public function __invoke(LoginRequest $request) : JsonResponse
    {

        // Get user email
        $user = User::where("email","=",$request->get("email"))->first();

        // Check if user email is found
        if ($user == null) {
            return ApiResponse::errorResponse("Email or Password is not right");
        }

        // Check password of the user
        if (!Hash::check($request->get("password"),$user->password)) {
            return ApiResponse::errorResponse("Email or Password is not right");
        }


        $token = $user->createToken("WebA browser");

        $user->token = $token->plainTextToken;

        return ApiResponse::successResponse("Login Successfully",200,new UserResource($user));
    }
}
