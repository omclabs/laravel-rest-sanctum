<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Auth\Events\Validated;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
  public function register(Request $request)
  {
    $fields = $request->validate([
      'name' => 'required|string',
      'email' => 'required|string|email|unique:users,email',
      'password' => 'required|confirmed'
    ]);

    $user = User::create([
      'name' => $fields['name'],
      'email' => $fields['email'],
      'password' => bcrypt($fields['password'])
    ]);

    return response()->json(format_return($user, [], 201), 201);
  }

  public function login(Request $request)
  {
    $fields = $request->validate([
      'email' => 'required|string|email',
      'password' => 'required'
    ]);

    $user = User::where([
      'email' => $fields['email'],
    ])->first();

    $user->token = $user->createToken('auth-token')->plainTextToken;

    if (!$user || !Hash::check($fields['password'], $user->password)) {
      return response()->json(format_return([], ['message' => 'Oopps user not found'], 401), 401);
    }

    return response()->json(format_return($user, [], 200), 200);
  }

  public function logout(Request $request)
  {
    $fields = $request->validate([
      'email' => 'required|string|email',
    ]);

    $user = User::where([
      'email' => $fields['email'],
    ])->first();

    $user->tokens()->delete();

    return response()->json(format_return([], [], 200, 'Logged Out'), 200);
  }
}
