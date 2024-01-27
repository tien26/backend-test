<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class AuthController extends Controller
{
    public function register(Request $request)
    {
        $request->validate([
            // 'name' => 'required|string',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|string',
        ]);

        $input = $request->only(['email', 'password', 'roles']);
        $input['password'] = bcrypt($request->password);
        $input['roles'] = 'user';
        $user = User::create($input);

        return $this->successResponse($user, 'register success', 201);
    }

    public function login(Request $request)
    {
        $request->validate([
            'email' => 'required|string',
            'password' => 'required|min:8',
        ]);

        if (!Auth::attempt($request->only('email', 'password'))) {
            return $this->errorResponse('email or password wrong!', 400);
        }
        $user = User::where('email', $request['email'])->first();

        // if (!$user->is_active) {
        //     return $this->errorResponse('the account is no active!', 404);
        // }
        // $expired = Passport::tokensExpireIn();
        // $refresh_expired = Passport::refreshTokensExpireIn();
        $token = $user->createToken('my-token');
        return $this->successResponse([
            'access_token' => $token->accessToken,
            // generate
            'rl' => $user->roles,
            'type' => 'bearer',
            'description' => 'enter token in format (Bearer <access_token>)',
        ], 'get token success');
    }

    public function logout()
    {
        $user = Auth::user()->token();
        $user->revoke();
        return $this->successResponse(null, 'logged out success');
    }
}
