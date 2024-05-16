<?php

use App\Http\Controllers\PetStoreController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('dashboard');
})->name('dashboard');

Route::prefix('pet')->group(function () {
    Route::get('', [PetStoreController::class, 'index'])->name('pet.index');
    Route::get('find', [PetStoreController::class, 'find'])->name('pet.find');
    Route::get('find-by-status', [PetStoreController::class, 'findByStatus'])->name('pet.find-by-status');
    Route::get('show', [PetStoreController::class, 'show'])->name('pet.show');

    Route::get('create', [PetStoreController::class, 'create'])->name('pet.create');
    Route::get('edit/{id}', [PetStoreController::class, 'edit'])->name('pet.edit');
    Route::post(null, [PetStoreController::class, 'store'])->name('pet.store');
    Route::put(null, [PetStoreController::class, 'update'])->name('pet.update');
    Route::delete('{id}', [PetStoreController::class, 'destroy'])->name('pet.destroy');
});

