<?php
use Illuminate\Support\Facades\Route;
use Webkul\Admin\Http\Controllers\Blacklist\BlacklistController;

Route::controller(BlacklistController::class)->prefix('blacklist')->group(function () {
    Route::get('', 'index')->name('admin.blacklist.index');

    // Visualiza uma despesa específica
    Route::get('view/{id}', 'view')->name('admin.blacklist.view');

    Route::get('create/{id?}', 'create')->name('admin.blacklist.create');

    Route::post('create', 'store')->name('admin.blacklist.store');

    Route::get('edit/{id?}', 'edit')->name('admin.blacklist.edit');

    Route::delete('/destroy/{id}', 'destroy')->name('admin.blacklist.destroy');

    Route::get('search', 'search')->name('admin.blacklist.search');

    Route::post('mass-destroy', 'massDestroy')->name('admin.blacklist.mass-destroy');
});