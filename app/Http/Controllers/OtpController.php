<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use App\Models\Otp;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;
use Symfony\Component\HttpFoundation\Response;

class OtpController extends Controller
{
    public function sendOtp(Request $request)
    {
        // Validate input
        $validator = Validator::make($request->all(), [
            'email' => 'required|email',
            'username' => 'required',
            'password' => 'required|min:6',
            'confirm_password' => 'required|same:password',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => 'error',
                'message' => $validator->errors()->first(),
            ], Response::HTTP_BAD_REQUEST);
        }

        try {
            // Generate a 6-digit OTP
            $otp = random_int(100000, 999999);

            // Store OTP in the database with expiration of 30 minutes
            $otpRecord = Otp::create([
                'email' => $request->email,
                'otp' => $otp,
                'expires_at' => now()->addMinutes(30),
            ]);

            // Send OTP to the email
            Mail::to($request->email)->send(new \App\Mail\OtpMail($otp));

            // Log the OTP
            Log::info("OTP sent to {$request->email}: {$otp}");

            return response()->json([
                'status' => 'success',
                'message' => 'OTP sent successfully',
            ], Response::HTTP_OK);

        } catch (\Exception $e) {
            // Log the error for debugging
            Log::error("OTP creation failed: {$e->getMessage()}");

            return response()->json([
                'status' => 'error',
                'message' => 'An error occurred while generating OTP.',
            ], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }
}
