@extends('adminlte::page')

@section('title', 'Usuário - Editar')

@section('content_header')
    <h1>Editar usuário</h1>
@stop

@section('content')
    <div class="class="container-fluid">

        @include('includes.alerts')

        <form action="{{ route('user.update', $data->id) }}" method="post">

            @method('PUT')
            @csrf

            <div class="form-row">

                <div class="col-6 form-group">
                    <label for="name">Nome</label>
                    <input required type="text" name="name" value="{{ old('name') ?? $data->name }}" id="name" class="form-control" placeholder="Nome" aria-describedby="nome">
                </div>

                <div class="col-6 form-group">
                    <label for="email">E-mail</label>
                    <input required type="text" name="email" value="{{ old('email') ?? $data->email }}" id="email" class="form-control" placeholder="E-mail" aria-describedby="e-mail">
                </div>

            </div>

            @can('adm')
                <div class="form-group">
                    <select required name="role" id="role" class="form-control">
                        <option {{ $data->role == 'adm'    ? 'selected' : '' }} value="adm">Administrador</option>
                        <option {{ $data->role == 'seller' ? 'selected' : '' }} value="seller">Vendedor</option>
                        <option {{ $data->role == 'client' ? 'selected' : '' }} value="client">Cliente</option>
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
