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



Route::group(['middleware' => ['web']], function () {
    //
    Route::get('/map', function(){
        return view('map');
    });

    Route::get('/', [
        'as' => 'public.home',
        'uses' => 'HomeController@index'
    ]);

    Route::group(['prefix'=>'user','middleware'=> 'auth:webadmin'],function(){
        Route::get('/',['as'=> 'user.home','uses'=> 'UserController@getHome']);
    });

    Route::get('AdminLogin',['as'=>'authApp.login', 'uses' =>'Auth\AuthController@getLogin']);

    Route::post('AdminLogin',['as'=>'authApp.post-login', 'uses' =>'Auth\AuthController@postLogin']);


    Route::get('/Logout',['as'=>'logout', 'uses' =>'Auth\AuthController@getLogout']);
    Route::get('/LogoutSocial',['as'=>'logoutSocial', 'uses' =>'Auth\AuthController@getLogoutSocial']);
    Route::group(['prefix'=> 'admin','middleware' => 'auth:webadmin'],function()
    {
        Route::get('/',['as'=>'admin.home', 'uses'=>'AdminController@getAdminHome']);

        Route::post('/AddCategory',['as'=>'addCategory','uses'=>'CatalogController@AddCategory']);
        Route::post('/AddBarrio',['as'=>'addBarrio','uses'=>'CatalogController@AddBarrio']);
        Route::post('/AddCpc',['as'=>'addCpc','uses'=>'CatalogController@AddCpc']);

        Route::post('UploadIcons',['as'=>'admin.uploadIcons','uses' => 'CatalogController@postUploadIcons']);
        Route::post('SaveBarrioLocation',['as'=>'admin.saveBarrioLocation','uses' => 'CatalogController@postSaveBarrioLocation']);



        Route::group(['namespace' => 'Auth'], function() {

            Route::get('CrearAppUser','AuthController@getCreateAppUser');
            Route::post('CrearAppUser',['as'=>'authApp.crearUser', 'uses' =>'AuthController@postCreateAppUser']);

        });

        Route::get('ObrasPresupAdmin',['as'=>'admin.obras','uses' => 'ObrasAdminController@getIndex']);

        Route::post('SaveObra',['as'=>'admin.saveObra','uses' => 'ObrasAdminController@postSaveObra']);
        Route::post('DeleteObra',['as'=>'admin.deleteObra','uses' => 'ObrasAdminController@postDeleteObra']);
        Route::post('GetAllObras',['as'=>'admin.getAllObras','uses' => 'ObrasAdminController@postGetAllObra']);

        Route::post('ImportFromFile',['as'=>'admin.importFromFile','uses' => 'ObrasAdminController@postLoadObrasFromFile']);

    });

    Route::get('/Obras',['as'=>'social.obras', 'uses' =>'ObrasSocialController@getIndex']);

    $s = 'social.';
    Route::get('/social/redirect/{provider}',   ['as' => $s . 'redirect',   'uses' => 'Auth\AuthController@getSocialRedirect']);
    Route::get('/social/handle/{provider}',     ['as' => $s . 'handle',     'uses' => 'Auth\AuthController@getSocialHandle']);



});















