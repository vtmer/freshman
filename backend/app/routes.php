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
        'uses' => 'Controllers\Backend\UserController@doLogout'
    ));

    Route::group(array('prefix' => 'artical','before' => ''),function(){

        Route::get('/',array(
           'as' => 'BackendShowArtical',
           'uses' => 'Controllers\Backend\ArticalController@showArtical'
       ));

        Route::get('/remove/{id}',array(
            'as' => 'BackendRemoveArtical',
            'uses' => 'Controllers\Backend\ArticalController@removeArtical'
        ));

        Route::get('/updown/{id}',array(
            'as' => 'BackendUpdownArtical',
            'uses' => 'Controllers\Backend\ArticalController@upDown'
        ));

        Route::get('/active/{id}',array(
            'as' => 'BackendActiveArtical',
            'uses' => 'Controllers\Backend\ArticalController@updateActive'
        ));
    });

    Route::group(array('prefix'=> 'edit','before'=> 'message'),function(){

        Route::get('/',array(
            'as' => 'BackendShowEditArtical',
            'uses' => 'Controllers\Backend\ArticalController@showEdit'
        ));

        Route::post('/',array(
            'as' => 'BackendSaveArtical',
            'uses' => 'Controllers\Backend\ArticalController@saveEdit'
        ));
    });

    Route::group(array('prefix' => '','before' => 'permission'),function(){


	    Route::get('/users',array(
		'as' => 'BackendShowUsers',
		'uses' => 'Controllers\Backend\UserController@showUser'
	    ));

	    Route::post('/users/new',array(
		'as' => 'BackendNewUsers',
		'uses' => 'Controllers\Backend\UserController@newUsers'
	    ));

	    Route::group(array('prefix' => 'catagory'),function(){

	    	Route::get('/',array(
		    'as' => 'BackendShowCatagory',
		    'uses' => 'Controllers\Backend\CatagoryController@showCatagory'
	    	 ));

    		Route::post('/update',array(
    		    'as' => 'BackendUpdateCatagory',
	    	    'uses' => 'Controllers\Backend\CatagoryController@updateCatagory'
	    	 ));

	    	Route::post('/new',array(
		        'as' => 'BackendNewCatagory',
	    	    'uses' => 'Controllers\Backend\CatagoryController@newCatagory'
	         ));

	    	Route::post('/{id}/delete',array(
	    	   'as' => 'BackendDeleteCatagory',
	    	   'uses' => 'Controllers\Backend\CatagoryController@deleteCatagory'
	    	  ));
    	});
    });

    Route::post('/{id}/password',array(
        'as' => 'BackendUpdateUser',
        'uses' => 'Controllers\Backend\UserController@updateUser'
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
    'uses' => 'Controllers\Backend\UserController@showLogin'
));
Route::post('/backend/login',array(
    'as' => 'BackendDoLogin',
    'uses' => 'Controllers\Backend\UserController@doLogin'
));

