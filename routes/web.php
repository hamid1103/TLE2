<?php

use Illuminate\Support\Facades\Route;
use \App\Http\Controllers\HomeController;
use \App\Http\Controllers\AIController;
use App\Http\Controllers\RegisterController;
use App\Http\Controllers\LoginController;

Route::get('/', [HomeController::class, 'index']);
Route::get('/getHistory/{id}',[AIController::class, 'getHistory']);
Route::get('/TestFakePrompt', [AIController::class, 'testFakeCompletionsPrompt']);
Route::get('/TestBasicChatPrompt', [AIController::class, 'TestBasicLLMChatPrompt']);
Route::delete('/delChat/{id}', [AIController::class, 'removeChatHistory']);
Route::post('/ChatLLM', [AIController::class, 'ChatPrompt']);

Route::post('/GenContextFromFile/{id}', [AIController::class,'GenerateContextFromText']);
Route::get('/getCSRF', [AIController::class,'getCSRF']);

Route::get('/subject',[\App\Http\Controllers\SubjectController::class,'subject']);

//Route::get('/register',[\App\Http\Controllers\RegisterController::class,'register']);
//Route::get('/login',[\App\Http\Controllers\LoginController::class,'login']);

Route::get('/register', [RegisterController::class, 'showRegistrationForm'])->name('register');
Route::post('/register', [RegisterController::class, 'register']);
Route::get('/login', [LoginController::class, 'showLoginForm'])->name('login');
Route::post('/login', [LoginController::class, 'login']);
Route::post('/logout', [LoginController::class, 'logout'])->name('logout');

Route::get('/joinGroup/{id}', [\App\Http\Controllers\DigibordController::class, 'AssignBoard']);
Route::get('/digibord', [\App\Http\Controllers\DigibordController::class,'digibordList']);
Route::get('/digibord/{id}', [\App\Http\Controllers\DigibordController::class,'digibord']);
Route::post('/digibord', [\App\Http\Controllers\DigibordController::class, 'createBoard']);
Route::post('/joinCode', [\App\Http\Controllers\DigibordController::class, 'JoinBoardWithCode']);
Route::post('/addQuestionToBoard', [\App\Http\Controllers\DigibordController::class, 'ChatEntryToBoard']);
