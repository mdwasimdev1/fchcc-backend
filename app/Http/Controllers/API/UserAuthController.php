<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use App\Traits\ResponseTrait;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Mail;
use App\Mail\OtpMail;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;
use Tymon\JWTAuth\Exceptions\JWTException;
use Tymon\JWTAuth\Exceptions\TokenInvalidException;
use Tymon\JWTAuth\Facades\JWTAuth;

class UserAuthController extends Controller
{
    use ResponseTrait;


    public function register(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:6|confirmed',
        ]);

        if ($validator->fails()) {
            return $this->error($validator->errors(), 'Validation Error', 422);
        }

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
        ]);

        $token = auth('api')->login($user);

        return $this->success([
            'user' => $user,
            'authorisation' => [
                'token' => $token,
                'type' => 'bearer',
            ]
        ], 'User created successfully', 201);
    }


    public function login(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'email' => 'required|string|email',
            'password' => 'required|string',
        ]);

        if ($validator->fails()) {
            return $this->error($validator->errors(), 'Validation Error', 422);
        }

        $credentials = $request->only('email', 'password');

        if (!$token = auth('api')->attempt($credentials)) {
            return $this->error(null, 'Unauthorized', 401);
        }

        $user = auth('api')->user();
        return $this->success([
            'user' => $user,
            'authorisation' => [
                'token' => $token,
                'type' => 'bearer',
            ]
        ], 'Logged in successfully');
    }


    //logout Api
    public function logout(Request $request)
    {
        try {

            $token = JWTAuth::getToken();

            if (!$token) {
                return $this->error([], 'Token not provided', 401);
            }
            $user = JWTAuth::authenticate($token);

            JWTAuth::invalidate($token);

            return $this->success(['name' => $user?->name,], 'Successfully logged out', 200);
        } catch (TokenInvalidException $e) {
            return $this->error([], 'Token is invalid', 401);
        } catch (JWTException $e) {
            return $this->error([], 'Logout failed: ' . $e->getMessage(), 500);
        }
    }



    public function sendOtp(Request $request)
    {
        $request->validate([
            'email'        => 'required|email'
        ]);

        $user = User::where('email', $request->email)->first();

        if (!$user) {
            return $this->error([], 'User with this email does not exist.', 404);
        }

        $otp = rand(100000, 999999);
        $expiredAt = Carbon::now()->addMinutes(10);
        $user->update([
            'otp'       => $otp,
            'otp_verified'  => false,
            'otp_attempts'  => 0,
            'otp_expired_at' => $expiredAt,
        ]);

        Mail::to($user->email)->send(new OtpMail($otp));

        return $this->success([
            'email' => $user->email,
            'otp' => $otp,
            'otp_verified' => $user->otp_verified,
            'otp_attempts' => $user->otp_attempts,
            'otp_expired_at' => $user->otp_expired_at,

        ], 'OTP sent successfully.', 200);
    }


    public function verifyOtp(Request $request)
    {
        $request->validate([
            'otp' => 'required|numeric',
            'email' => 'required|email|exists:users,email',
        ]);

        $user = User::where('email', $request->email)->first();

        if (!$user || $user->otp != $request->otp) {
            return $this->error([], 'Invalid otp', 400);
        }

        if (!$user->otp_expired_at || Carbon::parse($user->otp_expired_at)->isPast()) {
            $user->update([
                'otp' => null,
                'otp_expired_at' => null
            ]);

            return $this->error([], 'OTP expired', 400);
        }

        $user->update([
            'otp' => null,
            'otp_expired_at' => null,
            'otp_verified' => true,
            'otp_verified_at' => Carbon::now(),
            'password_reset_token' => Str::random(64),
            'password_reset_token_expired_at' => Carbon::now()->addMinutes(10),
        ]);

        return $this->success([
            'email' => $user->email,
            'password_reset_token' => $user->password_reset_token,
        ], 'OTP verified successfully', 200);
    }



    public function resetPassword(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'email'       => 'required|email',
            'password'    => 'required|string|min:6|confirmed',
            'password_reset_token' => 'required|string',
        ]);

        if ($validator->fails()) {
            return $this->error($validator->errors(), 'Error in Validation', 422);
        }

        $user = User::where('email', $request->email)->where('password_reset_token', $request->password_reset_token)->first();

        if (!$user) {
            return $this->error([], 'Invalid token or email.', 400);
        }

        if ($user->password_reset_token_expired_at < Carbon::now()) {
            return $this->error([], 'Token expired.', 400);
        }

        $user->password = Hash::make($request->password);
        $user->password_reset_token = null;
        $user->password_reset_token_expired_at = null;
        $user->save();


        // Attempt login after saving new password
        $credentials = $request->only('email', 'password');
        $token = JWTAuth::attempt($credentials);
        if (!$token) {
            return $this->error([], 'Unable to login. Please try again.', 401);
        }

        $userData = [
            'id'       => $user->id,
            'token'    => $token,
            'name'     => $user->name ?? 'User_name_' . uniqid(),
            'email'    => $user->email,
            'username' => $user->username ?? 'Username_' . uniqid(),
            'avatar'   => asset($user->avatar ?? 'user.jpg'),
        ];

        return $this->success($userData, 'Password reset & login successful', 200);
    }











    public function me()
    {
        return $this->success(auth('api')->user());
    }


    public function refresh()
    {
        return $this->success([
            'user' => auth('api')->user(),
            'authorisation' => [
                'token' => auth('api')->refresh(),
                'type' => 'bearer',
            ]
        ]);
    }
}
