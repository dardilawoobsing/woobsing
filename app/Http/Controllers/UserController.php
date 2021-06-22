<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Hash;
use App\Models\User;

class UserController extends Controller
{
    public function crear (Request $request){
        $input = $request->all();
        $input['password'] = Hash::make($request->password);
        User::create($input);
        return response()->json([
            'res' => true,
            'message' => 'usuario creado'
        ],200);
    }
    public function login(Request $request){
        $usuario = User::whereName($request->name)->first();
        if(!is_null($usuario) && Hash::check($request->password , $usuario->password)){
            $usuario->api_token = Str::random(100);
            $usuario->save();
            return response()->json([
                'res' => true,
                'token' => $usuario->api_token,
                'message' => 'logueo correcto'
            ],200);
        }else{
            return response()->json([
                'res' => false,
                'message' => 'error al loguearse'
            ],200); 
        }
    }
    public function logout(){
        $usuario = auth()->user();
        $usuario->api_token = null;
        $usuario->save();
        return response()->json([
            'res' => true,
            'message' => 'deslogueado'
        ],200);
    }
}
