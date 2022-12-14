<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\EventController;

use App\Http\Controllers\GitController;

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

Route::get('/', function () {
    return view('welcome');
});
Route::get('/', [GitController::class, 'authURL']);
Route::get('/getRepos', [GitController::class, 'getRepos']);
Route::post('/getRepos', [GitController::class, 'getRepos']);
?>