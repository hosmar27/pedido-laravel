@extends('layouts.app')
@section('content')
<section>
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
                    <label for="form-label">Cliente:</label>
                    <select class="form-control" name="cliente_id" id="cliente_id">
                        <option value="" disabled selected>Select cliente</option>

                        @foreach ($clientes as $cliente)
                        <option value="{{$cliente->id}}">
                            {{$cliente->nome}}
                        </option>
                        @endforeach
                    </select>
                </div>
                <div class="subcolumn" style="width: 20%;">
                    <label for="form-label">Contato:</label>

                    <select class="form-control" name="contato_id" id="contato_id">
                        <option value="" disabled selected>Select contato</option>
                        @foreach ($contatos as $contato)
                        <option value="{{$contato->id}}">
                            {{$contato->nome}}
                        </option>
                        @endforeach
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


    </body>

    </html>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script type="text/javascript">
        $("#cliente_id").change(function() {
            var idCliente = this.value
            $("#contato_id").html('');
            $.ajax({
                url: "{{url('api/fetch-contatos')}}",
                type: 'POST',
                data: {
                    cliente_id: idCliente,
                    _token: '{{csrf_token()}}'
                },
                dataType: 'json',
                success: function(result) {
                    $('#contato_id').html('<option value="">Select Contato</option>');
                    $.each(result.contato, function(key, value) {
                        $("#contato_id").append('<option value="' + value
                            .id + '">' + value.nome + '</option>');
                    });
                }
            });
        });
    </script>
    @endsection