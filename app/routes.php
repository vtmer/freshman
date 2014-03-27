<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the Closure to execute when that URI is requested.
|
*/



/*
|--------------------------------------------
| Frontend Route group
|--------------------------------------------
 */

Route::group(array('prefix' => '','before' => ''),function(){

    Route::get('/',array(
        'as' => 'FrontendShowIndex',
        'uses' => 'Frontend\HomeController@showindex'
    ));

});


/*
|--------------------------------------------
| Backend Route group
|--------------------------------------------
*/
Route::group(array('prefix' => 'backend','before' => 'auth'),function(){

    Route::get('/',array(
        'as' => 'BackendShowIndex',
        'uses' => 'Controllers\Backend\HomeController@showIndex'
    ));

    Route::get('/logout',array(
        'as' => 'BackendDoLogout',
        'uses' => 'Controllers\Backend\UserController@dologout'
    ));

    Route::get('/artical',array(
        'as' => 'BackendShowArtical',
        'uses' => 'Controllers\Backend\ArticalController@showartical'
    ));

    Route::get('/edit',array(
        'as' => 'BackendShowEditArtical',
        'uses' => 'Controllers\Backend\ArticalController@showedit'
    ));

    Route::group(array('prefix' => '','before' => 'permission'),function(){


	    Route::get('/users',array(
		'as' => 'BackendShowUsers',
		'uses' => 'Controllers\Backend\UserController@showuser'
	    ));

	    Route::post('/users/new',array(
		'as' => 'BackendNewUsers',
		'uses' => 'Controllers\Backend\UserController@newusers'
	    ));

	    Route::group(array('prefix' => 'catagory'),function(){

	    	Route::get('/',array(
		    'as' => 'BackendShowCatagory',
		    'uses' => 'Controllers\Backend\CatagoryController@showcatagory'
	    	 ));

    		Route::post('/update',array(
    		    'as' => 'BackendUpdateCatagory',
	    	    'uses' => 'Controllers\Backend\CatagoryController@updatecatagory'
	    	 ));

	    	Route::post('/new',array(
		        'as' => 'BackendNewCatagory',
	    	    'uses' => 'Controllers\Backend\CatagoryController@newcatagory'
	         ));

	    	Route::post('/{id}/delete',array(
	    	   'as' => 'BackendDeleteCatagory',
	    	   'uses' => 'Controllers\Backend\CatagoryController@deletecatagory'
	    	  ));
    	});
    });

    Route::post('/{id}/password',array(
        'as' => 'BackendUpdateUser',
        'uses' => 'Controllers\Backend\UserController@updateuser'
    ));
});

/* **********end of Backend Route group ********** */


/*
|--------------------------------------------
| Backend Route login and logout
|--------------------------------------------
 */

Route::get('/backend/login',array(
    'as' => 'BackendLogin',
    'uses' => 'Controllers\Backend\UserController@showlogin'
));
Route::post('/backend/login',array(
    'as' => 'BackendDoLogin',
    'uses' => 'Controllers\Backend\UserController@dologin'
));

