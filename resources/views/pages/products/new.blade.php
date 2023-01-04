@extends('adminlte::page')

@section('title', 'Produto - Novo')

@section('content_header')
    <h1>Adicionar produto</h1>
@stop

@section('content')
    <div class="class="container-fluid">

        @include('includes.alerts')

        <form action="{{ route('product.store') }}" method="post">

            @csrf

            <div class="form-group">
                <label for="name">Nome</label>
                <input required type="text" name="name" value="{{ old('name') }}" id="name" class="form-control" placeholder="Nome" aria-describedby="nome">
            </div>

            <div class="form-row">
                <div class="col-2 form-group">
                    <label for="price">Preço</label>
                    <div class="input-group">
                        <div class="input-group-prepend">
                            <span class="input-group-text">R$</span>
                        </div>
                        <input required type="text" name="price" value="{{ old('price') }}" id="price" class="form-control" placeholder="Preço" aria-describedby="preço">
                    </div>
                    <small class="form-text text-muted">Formato: 0.000,00</small>
                </div>

                <div class="col-10 form-group">
                    <label for="amount">Quantidade</label>
                    <input required type="number" name="amount" value="{{ old('amount') }}" id="amount" class="form-control" placeholder="Quantidade" aria-describedby="quantidade">
                </div>
            </div>

            <div class="form-group">
                <button type="submit" class="btn btn-success">
                    <i class="fas fa-paper-plane"></i>
                    Enviar
                </button>
            </div>

        </form>
    </div>
@stop
