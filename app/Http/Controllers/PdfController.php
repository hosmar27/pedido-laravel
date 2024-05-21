<?php

namespace App\Http\Controllers;

use App\Models\Pedido;
use App\Models\PedidoProduto;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;

class PdfController extends Controller
{
    public function gerarPDF()
    {
        $pedidoproduto = PedidoProduto::all();
        dd($pedidoproduto);
    }
}
