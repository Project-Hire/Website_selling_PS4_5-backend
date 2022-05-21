<?php

namespace App\Http\Controllers;

use App\Mail\UserVerification;
use Illuminate\Http\Request;

use Illuminate\Support\Facades\Auth;
use App\Models\User;
use Illuminate\Support\Facades\Mail;
use Validator;
use Carbon\Carbon;



class AuthController extends Controller
{
    public function register(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'full_name' => 'required|string|between:2,100',
            'number_phone' => 'string|between:10,20',
            'address' => 'required',
            'birth' => 'required|string|between:10,20',
            'gender' => 'required|boolean',
            'email' => 'required|string|email|max:100',
            'password' => 'required|string|min:6',
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors()->toJson(), 400);
        }
        $user = User::where('email', $request->email)->first();
        if ($user) {
            if ($user['confirm'] == true)
                return response()->json([
                    'message' => 'Email existed',
                ], 401);
            else {
                return response()->json([
                    'message' => 'This api just use for registering the first time.Please use api re_register to reregister',
                ], 400);
            }
        }
        $user = User::create(array_merge(
            $validator->validated(),
            [
                'password' => bcrypt($request->password),
                'confirm' => false,
                'confirmation_code' => rand(100000, 999999),
                'confirmation_code_expired_in' => Carbon::now()->addSecond(60)
            ]
        ));
//        try {
            Mail::to($user->email)->send(new UserVerification($user));
            return response()->json([
                'message' => 'Registered,verify your email address to login',
                'user' => $user
            ], 201);
//        } catch (\Exception $err) {
//            $user->delete();
//            return response()->json([
//                'error' => $err,
//                'message' => 'Could not send email verification,please try again',
//            ], 500);
//        }
        return response()->json([
            'message' => 'Failed to create',
        ], 500);
    }

    public function re_register(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'email' => 'required|string|email|max:100',
            // 'password' => 'string|min:6',
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors()->toJson(), 400);
        }
        $user = User::where('email', $request->email)->first();
        if ($user) {
            if ($user['confirm'] == true)
                return response()->json([
                    'message' => 'Email existed',
                ], 401);
            else {
                $user->confirmation_code = rand(100000, 999999);
                $user->confirmation_code_expired_in = Carbon::now()->addSecond(60);
                $user->save();
                try {
                    Mail::to($user->email)->send(new UserVerification($user));
                    return response()->json([
                        'message' => 'Registered again,verify your email address to login ',
                        'user' => $user
                    ], 201);
                } catch (\Exception $err) {
                    $user->delete();
                    return response()->json([
                        'message' => 'Could not send email verification,please try again',
                    ], 500);
                }
            }
        }
        return response()->json([
            'message' => 'Failed to re_register',
        ], 500);
    }

}
