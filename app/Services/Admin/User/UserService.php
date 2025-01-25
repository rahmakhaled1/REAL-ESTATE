<?php

namespace App\Services\Admin\User;

use App\Http\Requests\Admin\User\UserRequest;
use App\Http\Resources\Admin\UserResource;
use App\Models\User;

class UserService
{

    public function fetch_users()
    {
        $users = User::with('posts')->paginate(10);
        return response()->json([
            "status" => true,
            "data" => UserResource::collection($users),
            "message" => "The user data has been accessed successfully."
        ]);
    }

    public function delete_user(UserRequest $request)
    {
        $data = $request->validated();
        $userId = $data['user_id'];
        unset($data['user_id']);

        $user = User::find($userId);
        if (!$user) {
            return response()->json([
                "status" => false,
                "message" => "User not found.",
            ], 404);
        }
        $user->posts()->delete();
        $user->delete($data);

        return response()->json([
            "status" => true,
            "message" => "User deleted successfully.",
        ]);

    }

}
