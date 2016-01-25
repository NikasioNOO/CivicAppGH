<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the controller to call when that URI is requested.
|
*/

Route::get('/', function () {

    return view('welcome');

});

Route::get('home', [
    'as' => 'public.home',
    'uses' => 'HomeController@index'
]);

Route::group(['prefix'=> 'admin','middleware' => 'auth:Admin'],function()
{
   Route::get('/',['as'=>'admin.home', 'uses'=>'AdminController@getHome']);

});

Route::group(['prefix'=>'user','middleware'=> 'auth:Viewer'],function(){
   Route::get('/',['as'=> 'user.home','uses'=> 'UserController@getHome']);
});

Route::get('AdminLogin',['as'=>'authApp.login', 'uses' =>'Auth\AuthController@getLogin']);

Route::post('AdminLogin',['as'=>'authApp.post-login', 'uses'=>'Auth\AuthContoller@postLogin']);

Route::get('CrearAppUser',['as'=>'authApp.crearUser', 'uses' =>'Auth\AuthController@getCreateAppUser']);

Route::post('CrearAppUser',['as'=>'authApp.crearUser', 'uses' =>'Auth\AuthController@postCreateAppUser']);

/*
Route::get('CrearAppUser',function(){
   return view('auth.CreateAppUser');
});
*/