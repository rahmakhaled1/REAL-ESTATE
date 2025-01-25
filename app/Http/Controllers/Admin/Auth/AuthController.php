<?php

namespace App\Http\Controllers\Admin\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\LoginRequest;
use App\Services\Admin\AuthService;
use Illuminate\Http\Request;

class AuthController extends Controller
{
    public function __construct(protected AuthService $auth_service){}

    public function loginAdmin(LoginRequest $request)
    {
        return $this->auth_service->loginAdmin($request);
    }

    public function logoutAdmin(Request $request)
    {
        return $this->auth_service->logoutAdmin($request);
    }
}
