<?php

namespace App\Services;

use App\Exceptions\CreadentialNotValidException;
use App\Models\User;
use App\Models\UserSession;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\Hash;

class AuthService
{
    private $user;
    private $sessions;

    public function __construct(User $user, UserSession $sessions)
    {
        $this->user = $user;
        $this->sessions = $sessions;
    }

    public function login($data)
    {
        $user = $this->user
                ->where('email', $data['email'])
                ->first();
        if (!$user || !Hash::check($data["password"], $user["password"])) {
            throw new CreadentialNotValidException("Credentials not match", 1);
        }

        $token = substr(Crypt::encrypt(now()), 0, 60);
        $this->sessions->create([
            "user_id" => $user->id,
            "token" => $token
        ]);

        return [
            "token" => $token,
            "user" => $user,
        ];
    }

    public function logout($request)
    {
        $this->sessions->where('token', $request->bearerToken())->update(['is_active' => 0]);
        Auth::guard('web')->logout();
        return response()->json(['message' => 'Successfully logged out']);
    }
}