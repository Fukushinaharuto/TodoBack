<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;

class AuthenticatedSessionController extends Controller
{
    /**
     * Handle an incoming authentication request.
     */
    public function index() {
        $user = Auth::user();
        if($user){
            return response()->json([
                'name' => $user->name,
            ]);
        }else{
            return response()->json([
                'message' => 'ログインに失敗しました',
            ]);
        }
    }
    public function store(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        if(Auth::attempt(['email' => $request->email, 'password' => $request->password])){
            $user = Auth::user();
            $token = $user->createToken('token')->plainTextToken;
            return response()->json([
                'message' => 'ログインに成功しました',
                'token' => $token,
                'user' => $user,
            ], 200);
        }else{
            return response()->json([
                'message' => 'ログインに失敗しました',
            ]);
        }

        
    }

    
}
