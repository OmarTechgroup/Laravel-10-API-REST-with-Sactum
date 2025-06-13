<?php

use App\Http\Controllers\API\postcontroller;
use App\Http\Controllers\API\Usercontroller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

//recuperer la list des post
Route::get(
    'post',
    [postcontroller::class, 'index']
);








//Inscription un nouvel Utilisateur

Route::post('/register', [Usercontroller::class, 'register']);

//Connexion  Utilisateur

Route::post('/login', [Usercontroller::class, 'login']);





Route::middleware('auth:sanctum')->group(function () {



    //creation d'un post
    Route::post('post/create', [postcontroller::class, 'store']);

    //mise a jour d'un post
   Route::put('post/update/{post}', [postcontroller::class, 'update']);

   //suppression d'un post
Route::delete('post/{post}', [postcontroller::class, 'delete']);

    Route::get('/user', function (Request $request) {
        return $request->user();
    });

});
