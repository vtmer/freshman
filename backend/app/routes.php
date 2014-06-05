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
        'as' => 'FrontendIndex',
        'uses' => 'Controllers\Frontend\IndexController@showIndex'
    ));

    Route::get('/{id}',array(
        'as' => 'FrontendIndexBySchoolPart',
        'uses' => 'Controllers\Frontend\IndexController@showIndexBySchoolPart'
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

    Route::group(array('prefix' => 'article','before' => ''),function(){

        Route::get('/',array(
           'as' => 'BackendShowArticle',
           'uses' => 'Controllers\Backend\ArticleController@showArticle'
       ));

        Route::get('/{id}',array(
           'as' => 'BackendShowArticleByCatagory',
           'uses' => 'Controllers\Backend\ArticleController@showArticleByCatagory'
       ));

        Route::get('/remove/{id}',array(
            'as' => 'BackendRemoveArticle',
            'uses' => 'Controllers\Backend\ArticleController@removeArticle'
        ));

        Route::get('/updown/{id}',array(
            'as' => 'BackendUpdownArticle',
            'uses' => 'Controllers\Backend\ArticleController@upDown'
        ));

        Route::get('/active/{id}',array(
            'as' => 'BackendActiveArticle',
            'uses' => 'Controllers\Backend\ArticleController@updateActive'
        ));
    });

    Route::group(array('prefix'=> 'edit','before'=> 'message'),function(){

        Route::get('/',array(
            'as' => 'BackendShowEditArticle',
            'uses' => 'Controllers\Backend\ArticleController@showEdit'
        ));

        Route::post('/',array(
            'as' => 'BackendSaveArticle',
            'uses' => 'Controllers\Backend\ArticleController@saveEdit'
        ));

        Route::get('/update/{id}',array(
            'as' => 'BackendShowUpdateArticle',
            'uses'=> 'Controllers\Backend\ArticleController@showUpdateArticle'
        ));

        Route::post('/update/{id}',array(
            'as' => 'BackendUpdateArticle',
            'uses' => 'Controllers\Backend\ArticleController@updateArticle'
        ));
    });

    Route::group(array('prefix' => '','before' => 'group'),function(){

        Route::group(array('prefix' => 'users','before' => ''),function(){

    	    Route::get('/',array(
	        	'as' => 'BackendShowUsers',
	        	'uses' => 'Controllers\Backend\UserController@showUser'
    	    ));

	        Route::post('/new',array(
	        	'as' => 'BackendNewUsers',
	        	'uses' => 'Controllers\Backend\UserController@newUsers'
    	    ));

            Route::get('/remove/{id}',array(
                'as' => 'BackendRemoveUser',
                'uses' => 'Controllers\Backend\UserController@removeUser'
            ));
        });


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

