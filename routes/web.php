<?php

use Illuminate\Support\Facades\Route;

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

/*
Route::get('/', function () {
    return view('chiken-list');
});

Route::get('/chiken-register', function () {
    return view('chiken-register');
});
*/

Route::get('/', 'ChikenListController@index');
Route::post('/', 'ChikenListController@search');

Route::get('ChikenRegister', 'ChikenRegisterController@index');
Route::get('ChikenRegister/{chiken_id}', 'ChikenRegisterController@edit');
Route::post('ChikenRegister', 'ChikenRegisterController@post');

Route::get('ChikenDetail/{chiken_id}', 'ChikenDetailController@index');
Route::delete('ChikenDetail/yoyaku', 'ChikenDetailController@yoyaku_delete');

Route::get('QuestionSendYoyaku/{chiken_id}', 'QuestionSendYoyakuController@index');
Route::get('QuestionSendYoyaku/{chiken_id}/{yoyaku_id}', 'QuestionSendYoyakuController@edit');
Route::post('QuestionSendYoyaku', 'QuestionSendYoyakuController@post');

Route::get('QuestionSendTarget/{chiken_id}', 'QuestionSendTargetController@index');
Route::post('QuestionSendTarget', 'QuestionSendTargetController@post');

/* Line */
/*Route:post('/line/webhook', 'LineController@webhook');*/

/* Restƒf[ƒ^ */
Route::resource('question_template_mast', 'QuestionTemplateMastRestController');
Route::resource('soushin_yoyaku', 'SoushinYoyakuRestController');
