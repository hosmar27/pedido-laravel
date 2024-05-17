@extends('layouts.app')
@section('content')
<section>
    <head>
        <meta name="csrf-token" content="{{ csrf_token() }}">
    </head>
    <div class="container">
        <form action="{{ route('pedido.store')}}" method="post">
            @csrf
            <h1>Cadastrar pedidos</h1>
            @if($errors->any)
            <div>
                <ul>
                    @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
            @endif
            <div class="column" style="display: flex;flex-direction:row">
                <div class="subcolumn" style="width: 20%;">
                    <label id="cliente_id" for="clientes_id">Cliente:</label>
                    <select class="form-control" name="cliente_id" id="clientes_id">
                        <option value="" disabled selected>-- Cliente --</option>

                        @foreach ($clientes as $cliente)
                        <option value="{{$cliente->id}}">
                            {{$cliente->nome}}
                        </option>
                        @endforeach
                    </select>
                </div>
                <div class="subcolumn" style="width: 20%;">
                    <label id="contato_id" for="contatos_id">Contato:</label>
                    <select class="form-control" id="contatos_id" name="contato_id">
                    </select>
                </div>
                <div class="subcolumn" style="width:20%;display:flex"></div>
            </div>
            <div class="buttons">
                <button class="btn-submit" type="submit" action="{{ route('pedido.store')}}">Cadastrar</button>
                <a href="{{ route('pedido.index')}}">Voltar</a>
            </div>
        </form>
    </div>

    <script type="text/javascript">
        $(document).ready(function() {
            $('#clientes_id').on('change', function() {
                var clienteId = this.value;
                $("contatos_id").html('');
                $.ajax({
                    headers:{
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    url: "{{ url('/pedido/fetchContatos')}}",
                    type: "POST",
                    data: {
                        cliente_id: clienteId
                    },
                    dataType: 'json',
                    success: function (result) {
                        $('#contatos_id').html('<option value="">-- Contato --</option>');
                        $.each(result.contatos, function (key,value) {
                            $("#contatos_id").append('<option value="' + value.id + '">' + value.nome + '</option>');
                        });
                    }
                });
            });
        });
    </script>
    </body>
    </html>
@endsection