@extends('layouts.app')
@section('content')

<section>
    <form action="{{ route('pdfGerar') }}" method="get">
        <div class="container">
            <h1>PEDIDOS LISTADOS</h1>
            @foreach($pedidos_produtos as $pedido_produto)
                <div>
                    
                </div>
            @endforeach
        </div>
    </form>
</section>