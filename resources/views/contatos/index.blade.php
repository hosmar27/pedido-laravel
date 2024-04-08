@extends('layouts.app')
@section('content')
@vite(['resoucer/css/app.css','resources/js/app.js'])
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
</html>
    <section>
        <div class="container">
            <div class="column">
                <h1>Lista de Contatos</h1>
                <form method="GET" action="{{ route('contato.index') }}" accept-charset="UTF-8" role="search">
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
                        <th>Email</th>
                        <th>Cliente</th>
                        <th>Telefone</th>
                        <th>CPF</th>
                        <th>Excluir/Editar</th>
                    </tr>
                    @foreach ($contatos as $contato)
                    <tr> 
                        <td>{{$contato->nome}}</td>
                        <td>{{ Str::limit($contato->email, 20) }}</td>
                        <td>{{ Str::limit($contato->clientes_id, 20) }}</td>
                        <td>{{$contato->telefone}}</td>
                        <td>{{$contato->cpf}}</td>
                        <td class="action">
                            <a href="{{ route('contato.edit', $contato->id) }}" class="btn-submit" style="width: 100px;">Editar</a>
                            <form method="post" action="{{ route('contato.destroy', $contato->id) }}">
                                @csrf
                                @method('delete')
                                    <input type="submit" value="Excluir" class="btn-submit" style="width: 150px;">
                            </form>
                        </td>
                    </tr>
                    @endforeach
                </table>
                <div class="buttons">
                    <a href="{{ route('contato.create')}}" class="btn-submit" style="width: 100px;">Cadastrar</button></a>
                    <div class="table-paginate">
                        {{$contatos->links('layouts.pagination')}}
                    </div>
                </div>
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
            icon: "success",
            title: "Contato excluido"
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
            title: "Contato adicionado"
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
            icon: "success",
            title: "Contato atualizado"
        });
    </script>
@endif
@endsection