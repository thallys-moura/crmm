<?php

use Illuminate\Support\Facades\Route;
use Webkul\Admin\Http\Controllers\Remarketing\RemarketingController;

Route::controller(RemarketingController::class)->prefix('remarketing')->group(function () {
    // Exibe a lista de remarketing
    Route::get('', 'index')->name('admin.remarketing.index');

    // Visualiza um remarketing específico
    Route::get('view/{id}', 'view')->name('admin.remarketing.view');

    // Formulário para editar um remarketing
    Route::get('edit/{id}', 'edit')->name('admin.remarketing.edit');

    // Atualiza um remarketing existente
    Route::put('edit/{id}', 'update')->name('admin.remarketing.update');

    // Formulário para criar um novo remarketing
    Route::get('create/{id?}', 'create')->name('admin.remarketing.create');

    // Armazena um novo remarketing
    Route::post('create', 'store')->name('admin.remarketing.store');

    // Exclui um remarketing
    Route::delete('{id}', 'destroy')->name('admin.remarketing.delete');

    // Atualização em massa de remarketing (se necessário)
    Route::post('mass-update', 'massUpdate')->name('admin.remarketing.mass_update');

    // Exclusão em massa de remarketing (se necessário)
    Route::post('mass-destroy', 'massDestroy')->name('admin.remarketing.mass_destroy');

    // Pesquisa de remarketing
    Route::get('search', 'search')->name('admin.remarketing.search');
});
