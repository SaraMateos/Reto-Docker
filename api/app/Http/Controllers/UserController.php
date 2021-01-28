<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;
use App\Models\User;

class UserController extends Controller {

    //Registro de usuario
    public function register(Request $request) {
        $validator = Validator::make($request->all(), [
            "name" => "required",
            "email" => "required|email",
            "password" => "required"
        ]);

        if ($validator->fails()) {
            return response()->json(["status" => "failed", "validation_errors" => $validator->errors()]);
        }

        $inputs = $request->all();
        $inputs["password"] = Hash::make($request->password);

        $user = User::create($inputs);

        if (!is_null($user)) {
            return response()->json(["status" => "success", "message" => "Perfecto! Registro completado", "data" => $user]);
        }
        else {
            return response()->json(["status" => "failed", "message" => "Fallo a la hora de registrarse!"]);
        }
    }

    //Iniciar sesion
    public function login(Request $request) {

        $validator = Validator::make($request->all(), [
            "email" =>  "required|email",
            "password" =>  "required",
        ]);

        if($validator->fails()) {
            return response()->json(["validation_errors" => $validator->errors()]);
        }

        $user = User::where("email", $request->email)->first();

        if (is_null($user)) {
            return response()->json(["status" => "failed", "message" => "Whoops! Email no encontrado."]);
        }

        if(Auth::attempt(['email' => $request->email, 'password' => $request->password])){
            $user = Auth::user();
            $token = $user->createToken('token')->plainTextToken;

            return response()->json(["status" => "success", "login" => true, "token" => $token, "data" => $user]);
        } else {
            return response()->json(["status" => "failed", "success" => false, "message" => "Whoops! Contraseña incorrecta."]);
        }
    }
    
    //Detalles del usuario
    public function user() {
        $user = Auth::user();

        if (!is_null($user)) { 
            return response()->json(["status" => "success", "data" => $user]);
        } else {
            return response()->json(["status" => "failed", "message" => "Whoops! No se encuentra al usuario."]);
        }        
    }

    //Cerrar sesion de usuario
    public function logout(Request $request) {

        $user = Auth::guard('api')->user();

        if ($user) {
            $user->remember_token = null;
            $user->save();
        }

        return response()->json(['data' => 'Sesion del usuario cerrada.'], 200);
    }
}