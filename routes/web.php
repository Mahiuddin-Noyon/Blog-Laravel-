<?php

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;


Route::get('/', 'HomeController@index')->name('home');
Route::post('/subscriber','SubscriberController@store')->name('subscriber.store');
Route::get('posts','PostController@index')->name('post.index');
Route::get('post/{slug}','PostController@details')->name('post.details');
Route::get('category/{slug}','PostController@PostByCategory')->name('category.posts');
Route::get('tag/{slug}','PostController@PostByTag')->name('tag.posts');

Route::get('search','SearchController@search')->name('search');
Route::get('profile/{username}','AuthorController@profile')->name('author.profile');

Auth::routes();

//Starting all routes for blog template....

Route::group(['middleware'=>['auth']], function()
{
    Route::post('favorite/{post}/add','FavoriteController@add')->name('post.favorite');
    Route::post('comment/{post}','CommentController@store')->name('comment.store');
});

Route::group(['as' => 'admin.', 'prefix' => 'admin', 'namespace' => 'Admin', 'middleware' => ['auth', 'admin']], function () {

    Route::get('/dashboard', 'DashboardController@index')->name('dashboard');


    Route::get('/settings','SettingsController@index')->name('settings');
    Route::put('profile-update', 'SettingsController@updateprofile')->name('profile.update');
    Route::put('password-update', 'SettingsController@updatepassword')->name('password.update');
    Route::resource('tag', 'TagController');
    Route::resource('category', 'CategoryController');
    Route::resource('post', 'PostController');

    //Approve pending posts
    Route::get('/pending/post', 'PostController@pending')->name('post.pending');
    Route::put('/post/{id}/approve', 'PostController@approval')->name('post.approve');
    
    //View Comments
    Route::get('comments','CommentController@index')->name('comment.index');
    Route::delete('comments/{id}','CommentController@destroy')->name('comment.destroy');

    //View and action to Author on admin panel
    Route::get('authors','AuthorController@index')->name('authors.index');
    Route::delete('author/{id}','AuthorController@destroy')->name('author.destroy');

    // view or delete subcribers
    Route::get('/subcriber','SubscriberController@index')->name('subscriber.index');
    Route::delete('/subcriber/{id}','SubscriberController@destroy')->name('subscriber.destroy');
});

Route::group(['as' => 'author.', 'prefix' => 'author', 'namespace' => 'Author', 'middleware' => ['auth', 'author']], function () {

    Route::get('/dashboard', 'DashboardController@index')->name('dashboard');
    Route::resource('post', 'PostController');

    //View Comments
    Route::get('comments','CommentController@index')->name('comment.index');
    Route::delete('comments/{id}','CommentController@destroy')->name('comment.destroy');
    
    Route::get('/settings','SettingsController@index')->name('settings');
    Route::put('profile-update', 'SettingsController@updateprofile')->name('profile.update');
    Route::put('password-update', 'SettingsController@updatepassword')->name('password.update');
});


View::composer('layouts.frontend.partial.footer', function($view)
{
    $categories = App\Category::all();
    $view->with('categories', $categories);
});
