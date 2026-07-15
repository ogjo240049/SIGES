<?php

use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\PagosController;
use App\Http\Controllers\VehiculosController;
use App\Http\Controllers\InventariosController;
use App\Http\Controllers\ComprasController;
use App\Http\Controllers\ServiciosController;
use App\Http\Controllers\UsuariosController;
use App\Http\Controllers\BitacoraController;
use App\Http\Controllers\ChoferesController;
use App\Http\Controllers\ReportesController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    if (auth()->check()) {
        return redirect()->route('dashboard');
    }

    return view('auth.login');
});

Route::middleware('guest')->group(function () {
    Route::get('/login', [LoginController::class, 'create'])->name('login');
    Route::post('/login', [LoginController::class, 'store'])->name('login.attempt');
});

Route::middleware('auth')->group(function () {
    Route::get('/dashboard', [LoginController::class, 'dashboard'])->name('dashboard');
    Route::post('/logout', [LoginController::class, 'destroy'])->name('logout');

    Route::middleware('role.access:1,2,3')->group(function () {
        Route::resource('pagos', PagosController::class)->parameters(['pagos' => 'pago']);
    });

    Route::middleware('role.access:1,2,3')->group(function () {
        Route::resource('bitacoras', BitacoraController::class)->parameters(['bitacoras' => 'bitacora']);
        Route::resource('choferes', ChoferesController::class)->parameters(['choferes' => 'chofer']);
        Route::resource('servicios', ServiciosController::class)->parameters(['servicios' => 'servicio']);
    });

    Route::middleware('role.access:1')->group(function () {
        Route::resource('vehiculos', VehiculosController::class)->parameters(['vehiculos' => 'vehiculo']);
        Route::resource('inventarios', InventariosController::class)->parameters(['inventarios' => 'inventario']);
        Route::resource('compras', ComprasController::class)->parameters(['compras' => 'compra']);
        Route::resource('usuarios', UsuariosController::class)->parameters(['usuarios' => 'user']);
        Route::get('reportes', [ReportesController::class, 'index'])->name('reportes.index');
        Route::get('reportes/pdf', [ReportesController::class, 'downloadPdf'])->name('reportes.pdf');
    });

    Route::fallback(function () {
        abort(403, 'Acceso denegado.');
    });
});
