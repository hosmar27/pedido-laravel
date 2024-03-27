@extends('layouts.app')
@section('content')
@vite(['resoucer/css/app.css','resources/js/app.js'])

    <section>
        <div class="container">
            <div class="column">
                <h1>Lista de clientes</h1>
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
                                    <input type="submit" value="Excluir" class="btn-submit">
                            </form>
                        </td>
                    </tr>
                    @endforeach
                </table>
                <a href="{{ route('cliente.create')}}" class="btn-submit">Cadastrar Cliente</button></a>

            </div>
        </div>
    </section>
    </script>
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
            icon: "delete",
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
            icon: "update",
            title: "Cliente atualizado"
        });
    </script>
@endif
@endsection