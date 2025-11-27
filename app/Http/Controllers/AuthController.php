<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class AuthController extends Controller
{
    public function create()
    {
        return view('auth.signin');
    }

    public function registration(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|min:2|max:255',
            'email' => 'required|email|max:255',
            'password' => 'required|string|min:6|max:255',
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Регистрация прошла успешно',
            'data' => $validated
        ]);
    }
}
