<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\{ClienteController, ContatoController, PdfController, ProdutoController, PedidoController};

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

Route::resource('cliente', ClienteController::class);
Route::get('/cliente/{id}/edit',[ClienteController::class,'edit']);
Route::put('/cliente/{id}/update',[ClienteController::class,'update']);
Route::get('/cliente/{id}/destroy',[ClienteController::class,'destroy']);

Route::resource('contato', ContatoController::class);
Route::get('/contato/{id}/edit',[ContatoController::class,'edit']);
Route::put('/contato/{id}/update',[ContatoController::class,'update']);
Route::get('/contato/{id}/destroy',[ContatoController::class,'destroy']);

Route::resource('produto', ProdutoController::class);
Route::get('/pedido_produto/{id}/create',[PedidoController::class,'createPedidoProduto'])->name('pedido_produto.create');
Route::get('/produto/{id}/edit',[ProdutoController::class,'edit']);
Route::put('/produto/{id}/update',[ProdutoController::class,'update']);
Route::get('/produto/{id}/destroy',[ProdutoController::class,'destroy']);

Route::resource('pedido', PedidoController::class);
Route::get('/pedido/{id}/edit',[PedidoController::class,'edit']);
Route::put('/pedido/{id}/update',[PedidoController::class,'update']);
Route::get('/pedido/{id}/destroy',[PedidoController::class,'destroy']);
Route::post('/pedido/fetchContatos',[PedidoController::class,'fetchContatos'])->name('fetchContatos');
Route::get('/pdf/{id}/pedido', [PdfController::class, 'gerarPedidoPDF'])->name('pdfGerar.pedido');

Route::get('/pedido_produto/{id}/index',[PedidoController::class,'indexPedidoProduto'])->name('pedidoProduto.index');
Route::get('/pedido_produto/{id}/create', [PedidoController::class, 'createPedidoProduto'])->name('pedidoProduto.create');
Route::post('/pedido_produto/store', [PedidoController::class, 'storePedidoProduto'])->name('pedidoProduto.store');
Route::get('/pedido_produto/{id}/edit',[PedidoController::class,'editPedidoProduto'])->name('pedidoProduto.edit');
Route::post('/pedido_produto/{id}/update', [PedidoController::class, 'updatePedidoProduto'])->name('pedidoProduto.update');
Route::get('/pedido_produto/{id}/destroy', [PedidoController::class, 'destroyPedidoProduto'])->name('pedidoProduto.destroy');
Route::post('/pedido/fetchProduto',[PedidoController::class,'fetchProduto'])->name('fetchProduto');