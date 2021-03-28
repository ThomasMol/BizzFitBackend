<?php

namespace App\Http\Controllers;

use App\Models\Organization;
use App\Models\User;
use App\Traits\ApiResponser;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;
use PDO;

class AuthController extends Controller
{
    use ApiResponser;

    public function register(Request $request){
        $validator =  Validator::make($request->all(), [
            'first_name' => 'required|string|max:255',
            'last_name' => 'required|string|max:255',
            'email' => 'required|string|email|unique:users,email',
            'password' => 'required|string|min:6'
        ]);

        if ($validator->fails()) {
            return $this->error($validator->errors()->first(), 200);
        }

        $attr = $request->all();

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

    public function login(Request $request){

        $validator =  Validator::make($request->all(), [
            'email' => 'required|string|email',
            'password' => 'required|string|min:6'
        ]);

        if ($validator->fails()) {
            return $this->error($validator->errors()->first(), 200);
        }

        if (!Auth::attempt($request->all())) {
            return $this->error('Oops! Your email and password combination did not match', 401);
        }

        return $this->success([
            'token' => Auth::user()->createToken('API Token')->plainTextToken
        ]);
    }

    public function logout(){
        Auth::user()->tokens()->delete();
        return $this->success([
            'message' => 'Tokens Revoked'
        ]);
    }

    public function getProfile(){
        $user = Auth::user();
        return $this->success($user);
    }
}
