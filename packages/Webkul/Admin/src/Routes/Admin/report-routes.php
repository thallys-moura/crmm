<?php

use Illuminate\Support\Facades\Route;
use Webkul\Admin\Http\Controllers\ReportController;
use Webkul\Admin\Http\Controllers\Settings\UserController;

Route::controller(ReportController::class)->prefix('reports')->group(function () {
    Route::get('payment-days', 'getPaymentDays')->name('admin.reports.payment_days');
    Route::get('filter', 'filterReports')->name('admin.reports.filter');
    Route::get('reports/sellers', 'getUsers')->name('admin.reports.sellers');

    // Adicione outras rotas relacionadas a relatórios, se necessário
});