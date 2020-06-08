<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

// Route::middleware('auth:api')->get('/user', function (Request $request) {
//     return $request->user();
// });

Route::post('login', 'api\v1\LoginController@login')->name('login');
Route::post('register', 'api\v1\LoginController@register')->name('register');
 
Route::group(['prefix' => 'user',  'middleware' => ['auth:api']], 
function () {
    Route::get('details', 'api\v1\LoginController@details');
    Route::resource('events', 'api\v1\EventsController');
    Route::resource('schedules', 'api\v1\SchedulesController');
});

