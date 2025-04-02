<?php

use App\Http\API\BeneficiarioExcelController;
use App\Http\API\ExpesciaPrestadorController;
use App\Http\API\ImageController;
use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Storage;
use Inertia\Inertia;



// Rotas para o módulo ApolicePlano
Route::prefix('apoliceplano')->group(function () {
    Route::get('index', [\Apoliceplano\app\Http\Controllers\ApolicePlanoController::class, 'index'])->name('ApolicePlano.index');
    Route::post('store', [\Apoliceplano\app\Http\Controllers\ApolicePlanoController::class, 'store'])->name('ApolicePlano.store');
    Route::post('setBen', [\Apoliceplano\app\Http\Controllers\ApolicePlanoController::class, 'addBenApolice'])->name('ApolicePlano.set-ben');
    Route::post('setRule', [\Apoliceplano\app\Http\Controllers\ApolicePlanoController::class, 'newRule'])->name('ApolicePlano.set-rule');

})->middleware(['auth', 'verified']);

// Rotas para o módulo tipo-apolices
Route::prefix('tipo-apolice')->group(function () {
    Route::get('index', [\Apoliceplano\app\Http\Controllers\TipoApolicesController::class, 'index'])->name('TipoApolices.index');
})->middleware(['auth', 'verified']);

// Rotas para o módulo motivo-cancelamento
Route::prefix('motivos-de-cancelamento')->group(function () {
    Route::get('index', [\Apoliceplano\app\Http\Controllers\MotivoCancelamentoController::class, 'index'])->name('MotivoCancelamento.index');
})->middleware(['auth', 'verified']);

Route::prefix('reports',)->group(function (){
    Route::view('apolice', 'apolice.plano::apolice-plano' )->name('report.apolice');
});