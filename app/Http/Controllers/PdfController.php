<?php

namespace App\Http\Controllers;

use App\Models\Pedido;
use App\Models\PedidoProduto;
use Barryvdh\DomPDF\Facade\Pdf;

class PdfController extends Controller
{
    public function gerarPedidoPDF($id)
    {

        $pedidoproduto = PedidoProduto::select('pedidos.id','pedidos.cliente_id','pedidos.contato_id','pedidos.total',
                                        'pedidos_produtos.valor','pedidos_produtos.quantidade','pedidos_produtos.desconto',
                                        'pedidos_produtos.total AS total_pp','pedidos_produtos.produto_id',
                                        'pedidos_produtos.pedido_id','pedidos_produtos.observacao','produtos.nome',
                                        'pedidos_produtos.id AS id_pp','pedidos_produtos.valor_desconto')
                    ->join('pedidos', 'pedidos.id', '=', 'pedidos_produtos.pedido_id')
                    ->join('produtos', 'pedidos_produtos.produto_id', '=', 'produtos.id')
                    ->where('pedidos.id','=', $id)
                    ->whereNull('pedidos_produtos.deleted_at')
                    ->whereNull('pedidos.deleted_at')
                    ->whereNull('produtos.deleted_at')
                    ->get();

        $pedido = Pedido::select('pedidos.id','pedidos.cliente_id','clientes.id AS c_id','clientes.nome','clientes.cnpj','clientes.endereco','clientes.telefone',
                                'pedidos.contato_id','contatos.id AS cc_id','contatos.nome','contatos.email','contatos.telefone','contatos.cpf')
                        ->join('clientes', 'clientes.id', '=', 'pedidos.cliente_id')
                        ->join('contatos', 'contatos.id', '=', 'pedidos.contato_id')
                        ->where('pedidos.id', '=', $id)
                        ->whereNull('pedidos.deleted_at')
                        ->whereNull('clientes.deleted_at')
                        ->whereNull('contatos.deleted_at')
                        ->first();

        $totalValor = $pedidoproduto->sum('total_pp');
                        

        $pdf = PDF::loadView('pdf.pedido',compact('pedidoproduto','pedido','totalValor'));

        return $pdf->setPaper('a4')->stream('lista_pedidos.pdf');
    }
}
