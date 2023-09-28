<?php

namespace App\Http\Controllers\ApiControllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\ChangePasswordRequest;
use App\Http\Requests\Auth\OtpRequest;
use App\Http\Requests\Auth\OtpVerifyRequest;
use App\Http\Responses\ApiResponse;
use App\Mail\OtpMail;
use App\Models\Otp;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Hash;

class ForgetPasswordController extends Controller
{
    public function requestOtp(OtpRequest $request) : JsonResponse
    {
        // Check if there is otp request before minute
        $oldOtp = Otp::where("email","=",$request->email)->where("created_at",">",Carbon::now()->subSeconds(10))->first();
        if (!is_null($oldOtp)) {
            return ApiResponse::errorResponse("Please wait before request another code");
        }

        $user = User::where("email","=",$request->email)->first();

        if (!is_null($user)) {
            Otp::where("email","=",$user->email)->delete();
            $newCode = (string)rand(111111,999999);
            Otp::create(["email"=>$user->email,"code"=>\Hash::make((string)$newCode)]);

            // send mail
            \Mail::to($user->email)->send(new OtpMail($newCode));
        }


        return ApiResponse::successResponse("Otp sent to your mail please check it");
    }

    public function verifyOtp(OtpVerifyRequest $request) :JsonResponse {
        $otp  = Otp::where("email",$request->get("email"))->first()?->code;
        $otpCode = $request->get("otp");
        if (!is_null($otp) && Hash::check((string)$otpCode,(string)$otp)) {
           return ApiResponse::successResponse("Otp is right");
        }
        return ApiResponse::errorResponse("Otp is wrong or expired");
    }

    public function changePassword(ChangePasswordRequest $request) : JsonResponse {
        $user = User::where("email",$request->email)->first();
        $otp  = Otp::where("email",$request->get("email"))->first();

        if (is_null($user) || is_null($otp) || !Hash::check($request->otp,$otp->code)) {
            return ApiResponse::errorResponse("Email or Otp is not valid");
        }

        //Update Password

        $user->password = Hash::make((string)$request->password);
        $user->save();

        // Delete old otp
        $otp->delete();

        return ApiResponse::successResponse("Password changed successfully");
    }
}
