<?php

namespace App\Http\Controllers\Api\V1;

use App\Article;
use App\Http\Controllers\Controller;
use App\Http\Resources\UserResource;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class ApiController extends Controller
{
    public function register(Request $request){
        
        $user = new User();
        $user->name = $request->name ;
        $user->email = $request->email ;
        $user->password = Hash::make($request->password) ;
        $user->save();

        $token = $user->createToken('Api Token')->accessToken ;

        return response()->json([
            'result' => 1 ,
            'status' => 200 ,
            'message' => 'success' ,
            'token' => $token ,
        ]) ;

    }

    public function login(Request $request){

        $data = request()->only('email','password') ;
        
        if(Auth::attempt($data)){

            $user = Auth::user();
            $token = $user->createToken('Api Token')->accessToken ;

            return response()->json([
                'result' => 1 ,
                'status' => 200 ,
                'message' => 'success' ,
                'user' => $user ,
                'token' => $token ,
            ]) ;
        }else{
            
            return response()->json([
                'result' => 0 ,
                'status' => 500 ,
                'message' => 'fails' ,
            ]) ;
        }


    }

    public function profile(){

        $user = Auth::user();
        $data = new UserResource($user) ; //  single 

        // UserResource::collection($users) // array multi

        return response()->json([
            'result' => 1 ,
            'message' => 'success' ,
            'data' => $data  
        ]) ;

    }

    public function logout(){

        Auth::user()->token()->revoke() ;

        return response()->json([
            'result' => 1 ,
            'message' => 'success'
        ]) ;

    }

    public function articles(){

        $articles = Article::all() ;

        return response()->json([
            'result' => 1 ,
            'message' => 'success' ,
            'data' => $articles 
        ]);

    }

    public function article($id){

        $article = Article::find($id) ;

        return response()->json([
            'result' => 1 ,
            'message' => 'success' ,
            'data' => $article 
        ]);

    }
}
