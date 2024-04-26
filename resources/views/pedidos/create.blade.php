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
                    <label id="cliente_id" for="form-label">Cliente:</label>
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
                    <label id="contato_id" for="form-label">Contato:</label>
                    <select class="form-control" name="contato_id" id="contato_id">
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
            $('#cliente_id').on('change', function() {
                var clienteId = this.value;
                $("contato_id").html('');
                $.ajax({
                    url: "{{ url('api/fetch-contatos')}}",
                    type: "POST",
                    data: {
                        cliente_id: clienteId,
                        _token: '{{csrf_token()}}'
                    },
                    dataType: 'json',
                    success: function (result) {
                        $('#contato_id').html('<option value="">-- Select Contato --</option>');
                        $.each(result.contatos, function (key,value) {
                            $("#contato_id").append('<option value="' + value.id + '">' + value.nome + '</option>');
                        });
                    }
                });
            });
        });
    </script>
    </body>
    </html>
@endsection