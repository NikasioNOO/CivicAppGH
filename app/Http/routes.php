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

Route::group(['middleware' => ['api']], function () {

    Route::resource('Catalogo', 'CatalogoController', ['only' => ['show']]);
    Route::resource('ObraPP', 'ObraPPController', ['only' => ['index','show']]);
    Route::get('/ObraPP/Año/{year}/Categoria/{categoryId}/Barrio/{barrioId}', 'ObraPPController@Search');
    Route::get('/ObraPP/Posts/{id}', 'ObraPPController@GetPosts');

});
Route::group(['middleware' => ['web']], function () {
    //
    Route::get('/map', function(){
        return view('map');
    });

    Route::get('/', [
        'as' => 'public.home',
        'uses' => 'HomeController@index'
    ]);

    Route::get('/obraId/{obraId}',[
        'as' => 'publichome.obraId',
        'uses' => 'HomeController@getHomeWithObra'
    ]);

    Route::post('/saveOwnUser', [
        'as' => 'user.register',
        'uses' => 'Auth\AuthController@postCreateSocialUser'
    ]);

    Route::get('register/verify/{confirmationCode}', [
        'as' => 'confirmation_path',
        'uses' => 'Auth\AuthController@getConfirm'
    ]);

    Route::post('register/resendConfirmation/', [
        'as' => 'resend_mail_confirmation',
        'uses' => 'Auth\AuthController@postResendConfirmation'
    ]);


   /* Route::group(['prefix'=>'user','middleware'=> 'auth:webadmin'],function(){
        Route::get('/',['as'=> 'user.home','uses'=> 'UserController@getHome']);
    });*/

    Route::get('AdminLogin',['as'=>'authApp.login', 'uses' =>'Auth\AuthController@getLogin']);

    Route::post('AdminLogin',['as'=>'authApp.post-login', 'uses' =>'Auth\AuthController@postLogin']);

    Route::post('/SocialLogin',['as'=>'authApp.post-social-login', 'uses' =>'Auth\AuthController@postSocialLogin']);

    Route::get('/Logout',['as'=>'logout', 'uses' =>'Auth\AuthController@getLogout']);
    Route::get('/LogoutSocial',['as'=>'logoutSocial', 'uses' =>'Auth\AuthController@getLogoutSocial']);

    Route::group(['prefix'=> 'social','middleware' => 'auth:websocial'],function() {
        Route::post('/SendPost', ['as' => 'social.sendpost', 'uses'=> 'ObrasSocialController@postSendPost']);
        Route::post('/MarkPost', ['as' => 'social.markpost', 'uses'=> 'ObrasSocialController@postMarkPost']);
        Route::post('/SendPostComplaint', ['as' => 'social.sendcomplaint', 'uses'=> 'ObrasSocialController@postSendComplaint']);
    });


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
        Route::post('SaveObrasFromFile',['as'=>'admin.saveObrasFromFile','uses' => 'ObrasAdminController@postSaveObrasFromFile']);
        Route::post('GetPosts',['as'=>'admin.getPosts','uses' => 'ObrasAdminController@postGetPosts']);
        Route::post('RemovePhoto',['as'=>'admin.removePhoto','uses' => 'ObrasAdminController@postDeletePhoto']);
        Route::post('DeletePost',['as'=>'admin.deletePost','uses' => 'ObrasAdminController@postDeletePost']);
        Route::post('MarkAsSpamer',['as'=>'admin.markAsSpamer','uses' => 'ObrasAdminController@postMarkAsSpamer']);

    });

    Route::get('/Obras',['as'=>'social.obras', 'uses' =>'ObrasSocialController@getIndex']);

    $s = 'social.';
    Route::get('/social/redirect/{provider}',   ['as' => $s . 'redirect',   'uses' => 'Auth\AuthController@getSocialRedirect']);
    Route::get('/social/handle/{provider}',     ['as' => $s . 'handle',     'uses' => 'Auth\AuthController@getSocialHandle']);


});















