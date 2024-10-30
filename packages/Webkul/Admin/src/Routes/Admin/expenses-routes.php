<?php

use Illuminate\Support\Facades\Route;
use Webkul\Admin\Http\Controllers\Expense\ExpenseController;

Route::controller(ExpenseController::class)->prefix('expenses')->group(function () {
    // Exibe a lista de despesas
    Route::get('', 'index')->name('admin.expenses.index');
    
    // Visualiza uma despesa específica
    Route::get('view/{id}', 'view')->name('admin.expenses.view');
    
    // Formulário para editar uma despesa
    Route::get('edit/{id}', 'edit')->name('admin.expenses.edit');
    
    // Atualiza uma despesa existente
    Route::put('edit/{id}', 'update')->name('admin.expenses.update');

    Route::get('create/{id?}', 'create')->name('admin.expenses.create');

    Route::post('create', 'store')->name('admin.expenses.store');

    // Exclui uma despesa
    Route::delete('{id}', 'destroy')->name('admin.expenses.delete');
    
    // Atualização em massa de despesas (se necessário)
    Route::post('mass-update', 'massUpdate')->name('admin.expenses.mass_update');
    
    // Exclusão em massa de despesas (se necessário)
    Route::post('mass-destroy', 'massDestroy')->name('admin.expenses.mass_delete');
    
    // Pesquisa de despesas
    Route::get('search', 'search')->name('admin.expenses.search');
});