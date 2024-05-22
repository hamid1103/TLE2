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
Route::post('/GenContextFromFile/{id}', [AIController::class,'GenerateContextFromFile']);
