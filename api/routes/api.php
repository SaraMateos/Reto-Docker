<?php

use App\Http\Controllers\TaskController;
use App\Http\Controllers\UserController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;


//Pagina de inicio


//Inicio de sesion, registro y cerrar sesion
Route::post("register", [UserController::class, "register"]);
Route::post("login", [UserController::class, "login"]);
Route::post('logout', [UserController::class, "logout"]);

//sanctum auth middleware routes
Route::middleware('auth:api')->group(function() {

    Route::get("user", [UserController::class, "user"]);

});