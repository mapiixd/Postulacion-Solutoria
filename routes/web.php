<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\IndicadoresController;
use App\Http\Controllers\GraficoController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('inicio');
})->name('inicio');

//Ruta que muestra el JSON de los indicadores financieros, filtrados solo para recibir la UF
Route::get('indicadores', [IndicadoresController::class, 'solicitar_uf']);
//ruta que genera y muestra un token con mis credenciales
Route::get('token', [IndicadoresController::class, 'tkn']);
//ruta que sirve para llenar la base de datos y muestra los datos que fueron insertados
Route::get('llenardb', [IndicadoresController::class, 'llenar_db']);
//Ruta que conduce al CRUD de los indicadores
Route::resource('indicadores-crud', IndicadoresController::class);

Route::get('grafico', [IndicadoresController::class, 'g_indicadores']);

