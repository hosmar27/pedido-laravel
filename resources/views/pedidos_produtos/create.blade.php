@extends('layouts.app')
@section('content')
<section>
    <head>
        <meta name="csrf-token" content="{{ csrf_token() }}">
    </head>
    <div class="container">
        <form action="{{ route('pedido.storeProduto')}}" method="post">
            @csrf
            <h1>Inserir produtos</h1>
            @if($errors->any)
            <div>
                <ul>
                    @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
            @endif
            <div class="row">
                <div class="column">
                    <div class="subcolumn">
                        <label for="produto_id">Produto:</label>
                        <select class="form-control" id="produto_id" name="produto_id">
                            <option value="" disabled selected>-- Produto --</option>
                            @foreach ($produtos as $produto)
                            <option value="{{ $produto->id }}">{{ $produto->nome }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="subcolumn">
                        <label for="valor">Valor:</label>
                        <input type="text" placeholder="Ex: 5,0" class="form-control" id="valor" name="valor">
                    </div>
                    <div class="subcolumn">
                        <label for="descricao">Observacao:</label>
                        <input type="text" placeholder="Ex: Aparencia otima" class="form-control" name="descricao" id="descricao">
                    </div>
                </div>
                <div class="column">
                    <div class="subcolumn">
                        <label for="estoque">Estoque:</label>
                        <input type="text" placeholder="Ex: 1000" class="form-control" name="estoque" id="estoque">
                    </div>
                    <div class="subcolumn">
                        <label for="desconto">Desconto:</label>
                        <input type="text" placeholder="Ex: 4360,00" class="form-control" name="desconto" id="desconto" >
                    </div>
                    <div class="subcolumn" style="height:70px;width:20%;display:flex"></div>
                </div>
                <div class="buttons">
                    <button class="btn-submit" type="submit" action="{{ route('pedido.storeProduto')}}">Cadastrar</button>
                    <a href="{{ route('pedido.index')}}">Voltar</a>
                </div>
        </form>
    </div>

</section>
<script type="text/javascript">
        $(document).ready(function() {
            $('#produto_id').on('change', function() {
                var idProduto = this.value;
                $("valor").html('');
                $("descricao").html('');
                $("estoque").html('');
                $.ajax({
                    headers:{
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    url: "{{ url('/pedido/fetchProduto')}}",
                    type: "POST",
                    data: {
                        id: idProduto,
                        
                    },
                    dataType: 'JSON',
                    success: function (display) {


                        valor.setAttribute('value', display.valor);
                        //document.getElementById("valor").value = valor;
                        //$('#descricao').text(display.descricao);
                        //$('#estoque').text(display.estoque);
                        console.log(display);
                    }
                });
            });
        });
    </script>
@endsection