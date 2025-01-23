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

