<?php

namespace App\Http\Controllers;

use App\Models\Organization;
use App\Models\User;
use App\Traits\ApiResponser;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class AuthController extends Controller
{
    use ApiResponser;

    public function Register(Request $request){
        $attr = $request->validate([
            'first_name' => 'required|string|max:255',
            'last_name' => 'required|string|max:255',
            'email' => 'required|string|email|unique:users,email',
            'password' => 'required|string|min:6'
        ]);

        $user = User::create([
            'id' => (string) Str::uuid(),
            'organization_id' => Organization::first()->id,
            'permission_level' => 0,
            'first_name' => $attr['first_name'],
            'last_name' => $attr['last_name'],
            'password' => Hash::make($attr['password']),
            'email' => $attr['email']
        ]);

        return $this->success([
            'token' => $user->createToken('API Token')->plainTextToken
        ]);
    }

    public function Login(Request $request){
        $attr = $request->validate([
            'email' => 'required|string|email|',
            'password' => 'required|string|min:6'
        ]);

        if (!Auth::attempt($attr)) {
            return $this->error('Credentials not match', 401);
        }

        return $this->success([
            'token' => auth()->user()->createToken('API Token')->plainTextToken
        ]);
    }

    public function Logout(){
        auth()->user()->tokens()->delete();
        return $this->success([
            'message' => 'Tokens Revoked'
        ]);
    }
}
