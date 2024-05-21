<?php

namespace App\Http\Controllers;

use App\Models\PDF as ModelsPDF;
use App\Models\Pedido;
use App\Models\PedidoProduto;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;

class PdfController extends Controller
{
    public function gerarPDF()
    {
        $pedidos_produtos = PedidoProduto::all();

        $pdf = PDF::loadView('pdf.pedido',compact('pedidos_produtos'));

        return $pdf->setPaper('a4')->stream('lista_pedidos.pdf');
    }
}
