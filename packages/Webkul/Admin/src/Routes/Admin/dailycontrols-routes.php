<?php

use Webkul\Admin\Http\Controllers\DailyControls\DailyControlsController;

Route::controller(DailyControlsController::class)->prefix('daily-controls')->group(function () {
    // Exibe a lista de controles diários
    Route::get('', 'index')->name('admin.daily_controls.index');

    // Visualiza um controle diário específico
    Route::get('view/{id}', 'view')->name('admin.daily_controls.view');

    // Formulário para criar um novo controle diário
    Route::get('create/{id?}', 'create')->name('admin.daily_controls.create');

    // Armazena um novo controle diário
    Route::post('create', 'store')->name('admin.daily_controls.store');

    // Formulário para editar um controle diário
    Route::get('edit/{id}', 'edit')->name('admin.daily_controls.edit');

    // Atualiza um controle diário existente
    Route::put('edit/{id}', 'update')->name('admin.daily_controls.update');

    // Exclui um controle diário
    Route::delete('{id}', 'destroy')->name('admin.daily_controls.delete');

    // Atualização em massa de controles diários (se necessário)
    Route::post('mass-update', 'massUpdate')->name('admin.daily_controls.mass_update');

    // Exclusão em massa de controles diários (se necessário)
    Route::post('mass-destroy', 'massDestroy')->name('admin.daily_controls.mass_delete');

    // Pesquisa de controles diários
    Route::get('search', 'search')->name('admin.daily_controls.search');

    Route::get('stats', 'stats')->name('admin.daily_controls.stats');


});