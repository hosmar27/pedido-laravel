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
                            <select id="cliente_id" class="form-control" name="cliente_id">
                                <option value="" disabled selected>Selecione</option>
                                @foreach ($clientes as $data)
                                    <option value="{{ $key }}">{{ $value }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="subcolumn" style="width: 20%;">    
                            <label for="form-label">Contato:</label>
                            <select id="contato_id" class="form-control" name="contato_id">
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
                var clienteID = $(this).val();
                if(clienteID) {
                    $.ajax({
                        url: '/pedido/contato/'+clienteID,
                        type: "GET",
                        dataType: "json",
                        success:function(data) {                      
                            $('#contato_id').empty();
                            $.each(data, function(key, value) {
                                $('#contato').append('<option value="'+ key +'">'+ value +'</option>');
                            });
                        }
                    });
                } else {
                    $('#contato').empty();
                }
            });
        });
    </script>
@endsection
