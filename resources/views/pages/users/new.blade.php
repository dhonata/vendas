@extends('adminlte::page')

@section('title', 'Usuário - Novo')

@section('content_header')
    <h1>Adicionar usuário</h1>
@stop

@section('content')
    <div class="class="container-fluid">

        @include('includes.alerts')

        <form action="{{ route('user.store') }}" method="post">

            @csrf

            <div class="form-row">

                <div class="col-6 form-group">
                    <label for="name">Nome</label>
                    <input required type="text" name="name" value="{{ old('name') }}" id="name" class="form-control" placeholder="Nome" aria-describedby="nome">
                </div>

                <div class="col-6 form-group">
                    <label for="email">E-mail</label>
                    <input required type="text" name="email" value="{{ old('email') }}" id="email" class="form-control" placeholder="E-mail" aria-describedby="e-mail">
                </div>

            </div>

            <div class="form-row">

                <div class="col-6 form-group">
                    <label for="password">Senha</label>
                    <input required type="password" name="password" value="{{ old('password') }}" id="password" class="form-control" placeholder="Senha" aria-describedby="senha">
                </div>

                <div class="col-6 form-group">
                    <label for="password_confirmation">Confrimação de senha</label>
                    <input required type="password" name="password_confirmation" value="{{ old('password_confirmation') }}" id="password_confirmation" class="form-control" placeholder="Confirmação de senha" aria-describedby="confirmação de senha">
                </div>

            </div>

            @can('adm')
                <div class="form-group">
                    <select required name="role" id="role" class="form-control">
                        <option value="client">Selecione o tipo do usuário(Cliente)</option>
                        <option value="adm">Administrador</option>
                        <option value="seller">Vendedor</option>
                        <option value="client">Cliente</option>
                    </select>
                </div>
            @endcan

            <div class="form-group">
                <button type="submit" class="btn btn-success">
                    <i class="fas fa-paper-plane"></i>
                    Enviar
                </button>
            </div>

        </form>
    </div>
@stop
