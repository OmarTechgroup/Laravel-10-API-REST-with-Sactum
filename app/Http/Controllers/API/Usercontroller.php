<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Requests\logUserRequests;
use App\Http\Requests\registerUSER;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class Usercontroller extends Controller
{
    //

    public function register(registerUSER $request)
    {

        try {
            //creation d'un nouveau utlisateur

            $user = new User();

            $user->name = $request->name;

            $user->email = $request->email;

            $user->password = Hash::make($request->password, ['round' => 12]);

            $user->save();

            return response()->json([
            'status' => 201,
            'message' => "Utilisateur enregistrez avec succées !",
            "user" => $user
        ], 201);

        } catch (\Exception $th) {
            return response()->json($th);
        }



        


    }


    public function login (logUserRequests $request){
       

        if (auth()->attempt($request->only('email','password'))) {
            $user = auth()->user();

            $token = $user->createToken('auth_token')->plainTextToken;


              return response()->json([
            'status' => 200,
            'message' => "Utilisateur connecté !",
            'user'=>$user,
            'token'=>$token
        ], 200);
        } else {
            # code...
             return response()->json([
            'status' => 403,
            'message' => "Informations Invalid !",
        ], 403);
        }
        
    }
}
