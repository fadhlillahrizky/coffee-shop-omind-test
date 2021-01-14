<?php

namespace App\Http\Controllers;

use App\Entities\ResponseEntities;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use JWTAuth;
use Tymon\JWTAuth\Exceptions\JWTException;

class AuthorizationController extends Controller
{
    public function login(Request $request): ResponseEntities
    {
        $response = new ResponseEntities();

        $credentials = $request->only('email', 'password');

        try {
            if (!$token = JWTAuth::attempt($credentials)) {
                $response->message = 'Login failed, Token attemp';
                return $response;
            }
        } catch (JWTException $e) {
            $response->message = 'Log Authorization login';
            $response->data = [
                'credentials' => $credentials ,
                'data' => $e
            ];
        }

        $user = JWTAuth::parseToken()->authenticate();

        $response->success = true;
        $response->message = 'Detail User';
        $response->data = [
            'token' => $token,
            'user' => $user
        ];

        return $response;
    }

    public function register(Request $request): ResponseEntities
    {
        $response = new ResponseEntities();

        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:6|confirmed',
        ]);

        if ($validator->fails()) {
            $response->message = 'Param tidak sesuai';
            $response->data = $validator->errors();
            return $response;
        }

        $user = User::create([
            'name' => $request->get('name'),
            'email' => $request->get('email'),
            'password' => Hash::make($request->get('password')),
        ]);

        $token = JWTAuth::fromUser($user);

        $response->success = true;
        $response->message = 'Detail User';
        $response->data = [
            'token' => $token,
            'user' => $user
        ];

        return $response;
    }

    public function getAuthenticatedUser()
    {
        $response = new ResponseEntities();

        try {

            if (!$user = JWTAuth::parseToken()->authenticate()) {
                return response()->json(['user_not_found'], 404);
            }

        } catch (Tymon\JWTAuth\Exceptions\TokenExpiredException $e) {

            return response()->json(['token_expired'], $e->getStatusCode());

        } catch (Tymon\JWTAuth\Exceptions\TokenInvalidException $e) {

            return response()->json(['token_invalid'], $e->getStatusCode());

        } catch (Tymon\JWTAuth\Exceptions\JWTException $e) {

            return response()->json(['token_absent'], $e->getStatusCode());

        }

        $response->success = true;
        $response->message = 'Detail User';
        $response->data = $user;
    }

    public function getUserLogin()
    {
        $response = new ResponseEntities();

        $response->success = true;
        $response->message = 'Detail User';
        $response->data = JWTAuth::parseToken()->authenticate();

        return $response;
    }


    public function listUser()
    {
        return User::listUser();
    }

}
