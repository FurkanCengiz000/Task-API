<?php

use App\Http\Controllers\TaskController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::post('/tasks', [TaskController::class, 'store'])->name('tasks.store');
