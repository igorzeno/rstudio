<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\ArticlelistController;
use App\Http\Controllers\LogoutController;
use App\Http\Controllers\MessageController;
use App\Http\Controllers\AddarticleController;
use App\Http\Controllers\SearchbytagsController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\GreetController;
use App\Http\Controllers\LoadarticleController;
use App\Http\Controllers\DelarticleController;
use App\Http\Controllers\EditarticleController;

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

Route::get('/', [HomeController::class, 'index'])->name('/');

Route::get('/register', [RegisterController::class, 'index'])->name('register');
Route::post('/register', [RegisterController::class, 'store']);
Route::get('/greet', [GreetController::class, 'index'])->name('greet');

Route::get('/login', [LoginController::class, 'index'])->name('login');
Route::post('/login', [LoginController::class, 'store']);
Route::post('/logout', [LogoutController::class, 'logout'])->name('logout');

Route::post('/search-by-tags', [SearchbytagsController::class, 'search'])->name('searchTags');
Route::post('/load-article', [LoadarticleController::class, 'load'])->name('loadArticle');

Route::delete('/article/{article}', [DelarticleController::class, 'destroy'])->name('delete');
Route::post('/edit/{article}', [LoadarticleController::class, 'edit'])->name('edit');
Route::get('/editform/{article}', [LoadarticleController::class, 'editform'])->name('edit_form');

