<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

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
                'email' => $user->email,
            ]);
        }else{
            return response()->json([
                'message' => 'ログインに失敗しました',
            ]);
        }
    }

    public function update(Request $request) {
        $user = Auth::user();

    $validateData = $request->validate([
        'name' => 'nullable|string|max:255',
        'email' => 'nullable|email|unique:users,email,' . $user->id,
        'password' => 'nullable|min:8',
    ]);
        if(!empty($validateData['name'])){
            $user->name = $validateData['name'];
        }
        if(!empty($validateData['email'])){
            $user->email = $validateData['email'];
        }
        if(!empty($validateData['password'])){
            $user->password = Hash::make($validateData['password']);
        }
        $user->tokens()->delete();
        $newToken = $user->createToken('authToken')->plainTextToken;
        
        $user->save();

        return response()->json([
            'name' => $user->name,
            'email' => $user->email,
            'token' => $newToken,
        ]);
        
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

    public function passwordAuth(Request $request){
        $user = Auth::user();
        if (!$user) {
            return response()->json(['message' => 'Unauthorized'], 401);
        }
        $validateData = $request->validate([
            'password' => 'required|min:8'
        ]);
        $password = $validateData['password'];
        if(Hash::check($password, $user->password)){
            $permission = true;
        }else{
            $permission = false;
        }

        return response()->json([
            'permission' => $permission,
        ]);
    }


    
}
