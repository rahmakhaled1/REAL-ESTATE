<?php

namespace App\Http\Controllers\Admin\User;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\User\UserRequest;
use App\Services\Admin\User\UserService;
use Illuminate\Http\Request;

class UserController extends Controller
{
    public function __construct(protected UserService $user_services){}

    public function fetch_users()
    {
        return $this->user_services->fetch_users();
    }

    public function delete_user(UserRequest $request)
    {
        return $this->user_services->delete_user($request);
    }
}
