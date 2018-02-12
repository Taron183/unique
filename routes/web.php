<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::group([],function(){
    Route::match(['get','post'],'/',['uses'=>'IndexController@execute','as'=>'home']);
    Route::get('/page/{alias}',['uses'=>'PageController@execute','as'=>'page']);

    Route::auth();
});

Route::group( [ 'prefix' => 'admin', 'middleware' => 'auth','admin'], function () {
    //admin
    Route::get('/', function(){

        if(view()->exists('admin.index')){

            $data = ['title'=> 'Admin Panel'];

            return view('admin.index',$data);
        }


    });
    //admin/pages
    Route::group(['prefix'=> 'pages'],function(){

        //admin/pages
        Route::get('/',['uses'=>'PagesController@execute','as'=>'pages']);

        //admin/pages/add
        Route::match(['get','post'], '/add',['uses'=>'PagesController@pagesAdd','as'=>'pagesAdd']);
        Route::match(['get','post','delete'], '/edit/{page}',['uses'=>'PagesController@edit','as'=>'pagesEdit']);

    });


    Route::group(['prefix'=> 'portfolios'],function(){


        Route::get('/',['uses'=>'PortfolioController@execute','as'=>'portfolios']);


        Route::match(['get','post'], '/add',['uses'=>'PortfolioAddController@execut','as'=>'portfoliosAdd']);
        Route::match(['get','post','delete'], '/edit/{portfolio}',['uses'=>'PortfolioEditController@execut','as'=>'portfoliosEdit']);

    });


    Route::group(['prefix'=> 'services'],function(){


        Route::get('/',['uses'=>'ServiceController@execute','as'=>'services']);


        Route::match(['get','post'], '/add',['uses'=>'ServiceAddController@execut','as'=>'servicesAdd']);
        Route::match(['get','post','delete'], '/edit/{service}',['uses'=>'ServiceEditController@execut','as'=>'servicesEdit']);

    });
});
Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');
