<?php

use App\Http\Controllers\Api\V1\ApiController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/


Route::post('/v1/register', 'Api\V1\ApiController@register');
Route::post('/v1/login', 'Api\V1\ApiController@login');

Route::group(
    [
    'prefix' => 'v1' ,
    'namespace' => 'Api\V1' ,
    'middleware' => 'auth:api'
    ], function(){
        Route::get('/profile', 'ApiController@profile') ;
        Route::post('/logout', 'ApiController@logout') ;
    }
);

Route::group(
    [
        'prefix' => 'v1' ,
        'namespace' => "Api\V1",

    ], function(){
        Route::get('articles', 'ApiController@articles') ;
        Route::get('article/{id}', 'ApiController@article') ;
    }
);

