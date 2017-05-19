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

//index
Route::get('/', 'HomeController@index')->name('index');

//index.stats
Route::get('/stats', 'HomeController@stats')->name('stats');
Route::get('/stats/{id}', 'HomeController@statsDep')->name('stats.dep');

//index.contacts
Route::get('/contacts', 'HomeController@contacts')->name('contacts');
Route::get('/contacts/filter', 'HomeController@contactsFilter')->name('contacts.filter');

Route::get('/user/profile/{profile_url}', 'ProfileController@profileDescription')->name('user.profile');

//requests
Route::get('/requests', 'RequestsController@requests')->name('requests');
Route::get('/requests/filter', 'RequestsController@requestsFilter')->name('requests.filter');
Route::get('/requests/details/{detail_id}', 'RequestsController@requestsDetails')->name('requests.details');
Route::post('/requests/details/{detail_id}/comment', 'RequestsController@requestsComment')->name('requests.comment');
Route::get('/comment/report', 'RequestsController@commentReport')->name('comment.report');
Route::get('/comment/block', 'RequestsController@commentBlock')->name('comment.block');
Route::get('/requests/make', 'RequestsController@create')->name('requests.make');
Route::post('/requests/submit', 'RequestsController@submit')->name('requests.submit');
Route::post('/requests/{request_id}/rate', 'RequestsController@rate')->name('requests.rate');
Route::post('/requests/{request_id}/print', 'AdminController@printRequest')->name('requests.print');
Route::post('/requests/{request_id}/refuse', 'AdminController@refuseRequest')->name('requests.refuse');
Route::get('/requests/{request_id}/delete', 'RequestsController@deleteRequest')->name('requests.delete');

//admin
Route::get('/admin/users', 'AdminController@showUsers')->name('admin.users');
Route::get('/admin/user/{id}/unblock', 'AdminController@unblockUser')->name('user.unblock');
Route::get('/admin/user/{id}/block', 'AdminController@blockUser')->name('user.block');
Route::get('/admin/user/{id}/concede', 'AdminController@concede')->name('user.concede');
Route::get('/admin/user/{id}/revoke', 'AdminController@revoke')->name('user.revoke');
Route::get('/admin/comment/{id}/unblock', 'AdminController@unblockComment')->name('comment.unblock');
Route::get('/admin/users/filter', 'AdminController@usersFilter')->name('admin.users.filter');

//login
Route::post('/user/login', 'Auth\LoginController@login')->name('login');

//logout
Route::get('/user/logout', 'UserController@logout')->name('logout');

//create new user
Route::post('/user/create', 'Auth\RegisterController@create')->name('user.create');
Route::post('/user/save', 'UserController@save')->name('user.save');

//render page to create new user
Route::get('/user/register', 'Auth\RegisterController@register')->name('user.register');
Route::get('/user/edit', 'UserController@edit')->name('user.edit');

Route::get('/user/confirm/{confirmation}', 'Auth\RegisterController@confirm')->name('user.confirm');
Route::get('/user/recover', 'Auth\RegisterController@recover')->name('user.recover');
Route::post('/user/recover/submit', 'Auth\RegisterController@recoverSubmit')->name('user.recover.submit');
Route::get('/user/recover/{confirmation}', 'Auth\RegisterController@recoverConfirm')->name('user.recover.confirm');

/*
Route::post('/test', 'Auth\RegisterController@test')->name('test');
Route::get('/testrender', 'Auth\RegisterController@testRender')->name('testrender');
*/
