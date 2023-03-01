<?php

namespace App\Http\Controllers;


use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use JWTAuth;
use Tymon\JWTAuth\Exceptions\JWTException;
use Tymon\JWTAuth\Exceptions\TokenExpiredException;
use Tymon\JWTAuth\Exceptions\TokenInvalidException;

class UserController extends Controller{

    public function authenticate(Request $request){
        $credentials = $request->only('usuario', 'password');
        try {
            if (!$token = JWTAuth::attempt($credentials)) {
                return response()->json(['error' => 'Credenciales no validas'], 400);
            }
        } catch (JWTException $e) {
            return response()->json(['error' => 'Error al intentar crear el token'], 500);
        }
        return response()->json(compact('token'));
    }

    public function register(Request $request){
        $validator = Validator::make($request->all(), [
            'tipo_id' => 'required|int|max:2',
            'identificacion' => 'required|string|max:255|unique:auth_usuarios',
            'nombre1' => 'required|string|max:255',
            'nombre2' => 'max:255',
            'apellido1' => 'required|string|max:255',
            'apellido2' => 'required|string|max:255',
            'email' => 'required|string|max:255|unique:auth_usuarios',
            'telefono' => 'string|max:255',
            'usuario' => 'required|string|max:255',
            'password' => 'required|string|min:6|confirmed',
            'inactivo' => 'int|max:1'
        ]);
        if ($validator->fails()) {
            return response()->json($validator->errors()->toJson(), 400);
        }
        if($request->get('password') == $request->get('password_confirmation')){
            $user = User::create([
                'tipo_id' => $request->get('tipo_id'),
                'identificacion' => $request->get('identificacion'),
                'nombre1' => $request->get('nombre1'),
                'nombre2' => $request->get('nombre2'),
                'apellido1' => $request->get('apellido1'),
                'apellido2' => $request->get('apellido2'),
                'email' => $request->get('email'),
                'id_perfil' => $request->get('id_perfil'),
                'ciudad' => $request->get('ciudad'),
                'usuario' => $request->get('usuario'),
                'password_app' => sha1(md5($request->get('usuario').$request->get('password'))),
                'password' => Hash::make($request->get('password')),
                'inactivo' => $request->get('inactivo')
            ]);
        }else{
            return response()->json($validator->errors()->toJson(), 400);
        }
        $token = JWTAuth::fromUSer($user);
        return response()->json(compact('user', 'token'), 201);
    }

    public function getAuthenticatedUser(){
        try {
            if (!$user = JWTAuth::parseToken()->authenticate()) {
                return response()->json(['user_not_found'], 404);
            }
        } catch (TokenExpiredException $e) {
            return response()->json(['token_expired'], $e->getStatusCode());
        } catch (TokenInvalidException $e) {
            return response()->json(['token_invalid'], $e->getStatusCode());
        } catch (JWTException $e) {
            return response()->json(['token_absent'], $e->getStatusCode());
        }
        return response()->json(compact('user'));
    }

}
