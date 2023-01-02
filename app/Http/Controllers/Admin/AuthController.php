<?php

namespace App\Http\Controllers\Admin;

use App\Exceptions\CreadentialNotValidException;
use App\Http\Controllers\Controller;
use App\Services\AuthService;
use Illuminate\Http\Request;

class AuthController extends Controller
{
    private $auth;

    public function __construct(AuthService $auth)
    {
        $this->auth = $auth;
    }

    public function login(Request $request)
    {
        try {
            $data = $this->auth->login($request);
        } catch (CreadentialNotValidException $e) {
            return response()->json(['error' => $e->getMessage()], 401);
        }
        return response()->json($data);
    }
}
