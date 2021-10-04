<?php

namespace App\Http\Controllers;

use App\Http\Requests\AuthLoginRequest;
use App\User;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{

    public function login(AuthLoginRequest $request)
    {

        if ($token = $this->guard()->attempt($request->only('username', 'password'))) {
            return response()->json(['status' => 'success'], 200)->header('Authorization', "Bearer $token");
        }
        return response()->json(['error' => 'login_error'], 401);
    }



    public function logout()
    {
        $this->guard()->logout();
        return response()->json([
            'status' => 'success',
            'msg' => 'Até logo!'
        ], 200);
    }

    public function user()
    {
        $user = User::query()->find(Auth::id());
        $roleName = $user->role->name;

        return response()->json([
            'status' => 'success',
            'data' => $user->unsetRelation('role')->toArray() + ['role' => $roleName],
        ]);
    }
    public function refresh()
    {
        if ($token = $this->guard()->refresh()) {
            return response()
                ->json(['status' => 'successs'], 200)
                ->header('Authorization', "Bearer $token");
        }
        return response()->json(['error' => 'refresh_token_error'], 401);
    }
    private function guard()
    {
        return Auth::guard();
    }
}
