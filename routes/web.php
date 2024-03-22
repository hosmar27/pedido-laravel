<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ClienteController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function() {
    return view('clientes.index');
});

Route::resource('cliente', ClienteController::class);

Route::get('/clientes/{id}/edit','ClienteController@edit'); // Puxa o $id do cliente do index para o edit
Route::put('/clientes/{id}', 'ClienteController@update');   // Envia os novos dados ao controller para fazer a alteração no DB