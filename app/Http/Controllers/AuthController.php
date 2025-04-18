<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Tymon\JWTAuth\Facades\JWTAuth;
use App\Services\UtilityService;

class AuthController extends Controller
{
    protected $utilityService;

    public function __construct(UtilityService $utilityService)
    {
        $this->utilityService = $utilityService;
    }

    public function register(Request $request)
    {
        $this->validate($request, [
            'name'     => 'required',
            'email'    => 'required|email|unique:users',
            'password' => 'required|min:6'
        ]);

        try {
            $user = User::create([
                'name'     => $request->name,
                'email'    => $request->email,
                'password' => Hash::make($request->password)
            ]);

            $token = JWTAuth::fromUser($user);

            $data = [
                'user' => $user,
                'token' => $token
            ];

            return $this->utilityService->is201ResponseCreated('Registrasi berhasil', $data);
        } catch (\Exception $e) {
            return $this->utilityService->is500InternalServerError('Terjadi kesalahan saat registrasi');
        }
    }

    public function login(Request $request)
    {
        $this->validate($request, [
            'email' => 'required|email',
            'password' => 'required|string|min:6',
        ]);

        $credentials = $request->only(['email', 'password']);

        if (! $token = auth()->attempt($credentials)) {
            return $this->utilityService->is401Unauthorized('Email atau password salah');
        }

        $data = [
            'token' => $token
        ];

        return $this->utilityService->is200ResponseWithData('Login berhasil', $data);
    }

    public function me()
    {
        $user = auth()->user();

        if (!$user) {
            return $this->utilityService->is401Unauthorized('Token tidak valid atau sudah kedaluwarsa');
        }

        return $this->utilityService->is200ResponseWithData('User aktif', $user);
    }
}
