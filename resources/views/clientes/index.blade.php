@extends('layouts.app')
@section('content')
@vite(['resoucer/css/app.css','resources/js/app.js'])

<section>
    <div class="container">
        <div class="column">
            <h1>Lista de clientes</h1>
            <form method="GET" action="{{ route('cliente.index') }}" accept-charset="UTF-8" role="search">
                @csrf
                <div class="table-search" style="width: 350px;display:flex;flex-direction:row">
                    <div>
                        <button class="btn-submit" style="width: 100px;height:35px">
                            Procurar
                        </button>
                    </div>
                    <div class="relative">
                    <input class="search-input" type="text" name="search" placeholder=" Digite aqui..." value="{{ request('search') }}" style="border-radius: 20px;border-color:#8200E6;width: 175px;height:35px">
                    </div>
                </div>
            </form>
            <table class="table table-hover">
                <tr>
                    <th>Nome</th>
                    <th>CNPJ</th>
                    <th>Endereço</th>
                    <th>Telefone</th>
                    <th>Excluir/Editar</th>
                </tr>
                @foreach ($clientes as $cliente)
                <tr> 
                    <td>{{$cliente->nome}}</td>
                    <td>{{$cliente->cnpj}}</td>
                    <td>{{$cliente->endereco}}</td>
                    <td>{{$cliente->telefone}}</td>
                    <td class="action">
                        <a href="{{ route('cliente.edit', $cliente->id) }}" class="btn-submit">Editar</a>
                        <form method="post" action="{{ route('cliente.destroy', $cliente->id) }}">
                            @csrf
                            @method('delete')
                                <input type="submit" value="Excluir" class="btn-submit" style="width: 100px;">
                        </form>
                    </td>
                </tr>
                @endforeach
            </table>
            <div class="buttons">
                <a href="{{ route('cliente.create')}}" class="btn-submit" style="width: 150px;">Cadastrar</a>
                <div class="table-paginate">
                    {{$clientes->links('layouts.pagination')}}
                </div>
            </div>
        </div>
    </div>
</section>

@if ($message = Session::get('delete'))
    <script type="text/javascript">
        const Toast3 = Swal.mixin({
            toast: true,
            position: "top-end",
            showConfirmButton: false,
            timer: 3000,
            timerProgressBar: true,
            didOpen: (toast) => {
                toast.onmouseenter = Swal.stopTimer;
                toast.onmouseleave = Swal.resumeTimer;
            }
        });
        Toast3.fire({
            icon: "sucess",
            title: "Cliente excluido"
        });
    </script>
@endif
@if ($message = Session::get('sucess'))
    <script type="text/javascript">
        const Toast = Swal.mixin({
            toast: true,
            position: "top-end",
            showConfirmButton: false,
            timer: 3000,
            timerProgressBar: true,
            didOpen: (toast) => {
                toast.onmouseenter = Swal.stopTimer;
                toast.onmouseleave = Swal.resumeTimer;
            }
        });
        Toast.fire({
            icon: "success",
            title: "Cliente adicionado"
        });
    </script>
@endif
@if ($message = Session::get('update'))
    <script type="text/javascript">
        const Toast2 = Swal.mixin({
            toast: true,
            position: "top-end",
            showConfirmButton: false,
            timer: 3000,
            timerProgressBar: true,
            didOpen: (toast) => {
                toast.onmouseenter = Swal.stopTimer;
                toast.onmouseleave = Swal.resumeTimer;
            }
        });
        Toast2.fire({
            icon: "sucess",
            title: "Cliente atualizado"
        });
    </script>
@endif
@endsection