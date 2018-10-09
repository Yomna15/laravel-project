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

/*Route::get('/', function () {
    return view('welcome');
});
Route::get('/hi', function () {
    return "<h1>first hi</h1>";
});

Route::get('/about',function(){
    return view('pages/about');
});

Route::get('/useres/{id}',function($id){
    return "welcome to my first page ".$id;
});
*/



Route::get('/',"PagesController@index");

Route::get("/about","PagesController@about");

Route::get("/services","PagesController@services");

Route::resource("posts","PostsController"); //post here (first parameter) is the route name
Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');
