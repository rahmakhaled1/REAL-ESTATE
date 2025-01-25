<?php

use App\Http\Controllers\Dashboard\Auth\AuthController;
use App\Http\Controllers\Dashboard\Post\PostController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/
/* Start Admin */
Route::group(
    ["prefix" => "admin"],
    function (){
        Route::controller(App\Http\Controllers\Admin\Auth\AuthController::class)->group(function () {
            Route::post("login","loginAdmin");
            Route::post("logout","logoutAdmin")->middleware(["auth:admin"]);
        });
    });
Route::group(
    ["prefix" => "admin", "middleware" => ["auth:admin"]],
    function () {
        Route::controller(App\Http\Controllers\Admin\Post\PostController::class)->group(function () {
            Route::post("fetch-posts", "fetch_posts");
            Route::post("update", "update");
            Route::post("delete", "delete");
        });
        Route::controller(App\Http\Controllers\Admin\User\UserController::class)->group(function () {
            Route::post("fetch-users", "fetch_users");
            Route::post("delete-user", "delete_user");
        });
    }
);
/* End Admin */

/* Start Dashboard User */
Route::group(
    [],
    function (){
        Route::controller(AuthController::class)->group(function () {
            Route::post("register","register");
            Route::post("login","login");
            Route::post("logout","logout")->middleware(["auth:sanctum"]);
        });
    });

Route::group(
    ["prefix" => "dashboard/posts", "middleware" => ["auth:sanctum"]],
    function () {
        Route::controller(PostController::class)->group(function () {
            Route::post("fetch-posts", "fetch_posts");
            Route::post("store", "store");
            Route::post("update", "update");
            Route::post("delete", "delete");
        });
    }
);
/* End Dashboard User */

/* Start User */
Route::group(
    ["prefix" => "real-estate/posts"],
    function (){
        Route::controller(App\Http\Controllers\Website\PostController::class)->group(function () {
            Route::post("fetch","fetch");
            Route::post("show","show");
            Route::post("search","search");
        });
    });
/* End User */
