<?php

use Illuminate\Support\Facades\Route;
use Webkul\Admin\Http\Controllers\Bank\BankController;

Route::controller(BankController::class)->prefix('bank')->group(function () {
    // Exibe a lista de despesas
    Route::get('', 'index')->name('admin.bank.index');

    // Visualiza uma despesa específica
    Route::get('view/{id}', 'view')->name('admin.bank.view');

    // Formulário para editar uma despesa
    Route::get('edit/{id}', 'edit')->name('admin.bank.edit');

    // Atualiza uma despesa existente
    Route::put('edit/{id}', 'update')->name('admin.bank.update');

    Route::get('create/{id?}', 'create')->name('admin.bank.create');

    Route::post('create', 'store')->name('admin.bank.store');

    // Exclui uma despesa
    Route::delete('{id}', 'destroy')->name('admin.bank.delete');

    // Atualização em massa de despesas (se necessário)
    Route::post('mass-update', 'massUpdate')->name('admin.bank.mass_update');

    // Exclusão em massa de despesas (se necessário)
    Route::post('mass-destroy', 'massDestroy')->name('admin.bank.mass_delete');

    // Pesquisa de despesas
    Route::get('search', 'search')->name('admin.bank.search');

    Route::get('stats', 'stats')->name('admin.bank.stats');

});
