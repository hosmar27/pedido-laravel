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
                                <option value="" disabled selected>Select cliente</option>
                                @foreach ($clientes as $data)
                                    <option value="{{$data->id}}">{{$data->nome}}</option>
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


</body>
</html>
@endsection

<script type="text/javascript" src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js">
    $(document).ready(function(){
    $('#cliente_id').on('change', function () {
        var idCliente = this.value;
        $("#contato_id").html('');
        $.ajax({
            url: '{{url("cliente/fetchContato")}}'+idCliente,
            type: "POST",
            data: { cliente_id: idCliente},
            success: function (result) {
                alert()
                $('#contato_id').html('<option value="">Select contato</option>');
                $.each(result.contatos, function (key, value) {
                    $("#contato_id").append('<option value="' + value
                        .id + '">' + value.name + '</option>');
                });
            }
        });
    });
    });
</script>