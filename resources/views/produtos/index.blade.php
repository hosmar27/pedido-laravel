@extends('layouts.app')
@section('content')
@vite(['resoucer/css/app.css','resources/js/app.js'])

    <section>
        <div class="container">
            <div class="column">
                <h1>Lista de produtos</h1>
                    <form method="GET" action="{{ route('produto.index') }}" accept-charset="UTF-8" role="search">
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
                        <th>Estoque</th>
                        <th>Valor</th>
                        <th>Descrição</th>
                        <th>Excluir/Editar</th>
                    </tr>
                    @foreach ($produtos as $produto)
                    <tr> 
                        <td>{{$produto->nome}}</td>
                        <td>{{$produto->estoque}}</td>
                        <td>{{$produto->valor}}</td>
                        <td>{{$produto->descricao}}</td>
                        <td class="action">
                            <a href="{{ route('produto.edit', $produto->id) }}" class="btn-submit" style="width: 100px;">Editar</a>
                            <form method="post" action="{{ route('produto.destroy', $produto->id) }}">
                                @csrf
                                @method('delete')
                                    <input type="submit" value="Excluir" class="btn-submit" style="width: 100px;">
                            </form>                        
                        </td>
                    </tr>
                    @endforeach
                </table>
                <div class="buttons">
                    <a href="{{ route('produto.create')}}" class="btn-submit" style="width: 150px;">Cadastrar</button></a>
                    <div class="table-paginate">
                        {{$produtos->links('layouts.pagination')}}
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
            icon: "success",
            title: "produto excluido"
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
            title: "produto adicionado"
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
            title: "produto atualizado"
        });
    </script>
@endif
@endsection