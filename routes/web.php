<?php

use Illuminate\Support\Facades\Route;
use \App\Http\Controllers\HomeController;
use \App\Http\Controllers\AIController;

Route::get('/', [HomeController::class, 'index']);
Route::get('/getHistory/{id}',[AIController::class, 'getHistory']);
Route::get('/TestFakePrompt', [AIController::class, 'testFakeCompletionsPrompt']);
Route::get('/TestBasicChatPrompt', [AIController::class, 'TestBasicLLMChatPrompt']);
Route::delete('/delChat/{id}', [AIController::class, 'removeChatHistory']);
Route::post('/ChatLLM', [AIController::class, 'ChatPrompt']);
Route::get('/subject',[\App\Http\Controllers\SubjectController::class,'subject']);
Route::get('/joinGroup/{id}', [\App\Http\Controllers\DigibordController::class, 'AssignBoard']);
Route::get('/digibord', [\App\Http\Controllers\DigibordController::class,'digibordList']);
Route::get('/digibord/{id}', [\App\Http\Controllers\DigibordController::class,'digibord']);
