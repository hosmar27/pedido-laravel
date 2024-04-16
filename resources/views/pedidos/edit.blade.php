@extends('layouts.app')
@section('content')
    <section>
        <div class="container">
            <form action="/pedido/update" method="POST">
            @csrf
            @method('PUT')
                <h1>Editar pedidos</h1>
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
                            <select name="" id=""></select>
                        </div>
                        <div class="subcolumn">
                            <select name="" id=""></select>
                        </div>
                    </div>
                    <div class="column"> 
                        <div class="buttons">
                            <button class="btn-submit" type="submit" action="{{ route('pedido.store')}}">Editar</button>
                            <a href="{{ route('pedido.index')}}">Voltar</a>
                        </div>
                    </div>
                </div>
            </form>
        </div>
        
    </section>
@endsection