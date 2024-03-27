@extends('layouts.app')
@section('content')
    <section>
        <div class="container">
            <form action="{{ route('contato.store')}}" method="post">
            @csrf
                <h1>Cadastrar Contatos</h1>
                @if($errors->any)
                <div>
                    <ul>
                        @foreach($errors->all() as $error)
                        <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
                @endif
                <div class="row">
                    <div class="column">
                        <div class="subcolumn">
                            <label for="form-label">Nome:</label>
                            <input type="text" placeholder="Insira o nome" class="form-control" name="nome" id="nome">
                        </div>
                        <div class="subcolumn">    
                            <label for="form-label">Email:</label>
                            <input type="text" placeholder="Insira o email" class="form-control" name="email" id="email">
                        </div>     
                    </div>
                    <div class="column">
                        <div class="subcolumn">
                            <label for="form-label">Telefone:</label>
                            <input type="text" placeholder="Insira o telefone" class="form-control" name="telefone" id="telefone">
                        </div>
                        <div class="subcolumn">    
                            <label for="form-label">CPF:</label>
                            <input type="text" placeholder="Insira o CPF" class="form-control" name="cpf" id="cpf">
                        </div>              
                    </div>
                </div>
                <div class="buttons">
                    <button class="btn-submit" type="submit" action="{{ route('contato.store')}}">Cadastrar</button>
                    <a href="{{ route('contato.index')}}">Voltar</a>
                </div>
            </form>
        </div>
        
    </section>
@endsection