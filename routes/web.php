<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\FormController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/


Route::get('/', [FormController::class, 'index'])->name('form.index');

Route::get('/create', [FormController::class, 'create'])->name('form.create');

Route::get('/form/{id}', [FormController::class, 'show'])->name('form.show');

Route::post('/save-form', [FormController::class, 'save'])->name('save.form');

// Edit a specific form
Route::get('/form/{id}/edit', [FormController::class, 'edit'])->name('form.edit');

// Update a specific form
Route::put('/form/{id}', [FormController::class, 'update'])->name('form.update');

// Delete a specific form
Route::delete('/form/{id}', [FormController::class, 'destroy'])->name('form.destroy');
