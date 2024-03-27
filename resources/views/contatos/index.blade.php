@extends('layouts.app')
@section('content')
@vite(['resoucer/css/app.css','resources/js/app.js'])

    <section>
        <div class="container">
            <div class="column">
                <h1>Lista de Contatos</h1>
                <form method="GET" action="{{ route('contato.index') }}" accept-charset="UTF-8" role="search">
                    <div class="table-search">
                        <div>
                            <button class="search-select">
                                Search Product
                            </button>
                            <span class="search-select-arrow">
                                <i class="fas fa-caret-down"></i>
                            </span>
                        </div>
                        <div class="relative">
                            <input class="search-input" type="text" name="search" placeholder="Search product..." value="{{ request('search') }}">
                        </div>
                    </div>
                </form>
                <table class="table table-hover">
                    <tr>
                        <th>Nome</th>
                        <th>Email</th>
                        <th>Telefone</th>
                        <th>CPF</th>
                        <th>Excluir/Editar</th>
                    </tr>
                    @foreach ($contatos as $contato)
                    <tr> 
                        <td>{{$contato->nome}}</td>
                        <td>{{$contato->email}}</td>
                        <td>{{$contato->telefone}}</td>
                        <td>{{$contato->cpf}}</td>
                        <td class="action">
                            <a href="{{ route('contato.edit', $contato->id) }}" class="btn-submit" style="width: 100px;">Editar</a>
                            <form method="post" action="{{ route('contato.destroy', $contato->id) }}">
                                @csrf
                                @method('delete')
                                    <input type="submit" value="Excluir" class="btn-submit" style="width: 100px;">
                            </form>
                        </td>
                    </tr>
                    @endforeach
                </table>
                <a href="{{ route('contato.create')}}" class="btn-submit" style="width: 100px;">Cadastrar Contato</button></a>

            </div>
        </div>
    </section>
    </script>
@if ($message = Session::get('deleted'))
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