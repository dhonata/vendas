@extends('adminlte::page')

@section('title', 'Produtos')

@section('content_header')
    <h1>
        Produtos
        @can('sell')
            |
            <a href="{{ route('product.new') }}">
                <div class="btn btn-success">
                    <i class="fas fa-plus"></i> Cadastrar produto
                </div>
            </a>
            @endcan
    </h1>
@stop

@section('content')
    <div class="class="container-fluid">

        @include('includes.alerts')

        <table class="table table-striped">
            <thead>
                <tr>
                    <th>#</th>
                    <th>Nome</th>
                    <th>Preço</th>
                    <th>Quantidade</th>
                    <th>Ações</th>
                </tr>
            </thead>
            @foreach ($datas as $data)
                <tr>
                    <td>{{ str_pad($data->id, 3, '0', STR_PAD_LEFT) }}</td>
                    <td>{{ $data->name }}</td>
                    <td>R$ {{ number_format($data->price, 2, ',', '.') }}</td>
                    <td>{{ $data->amount }}</td>
                    @can('sell')
                        <td width='25%' >
                    @else
                        <td width='10%' >
                    @endcan
                        <a href="{{ route('product.show', $data->id) }}">
                            <div class="btn btn-success">
                                <i class="fas fa-eye"></i> Visualizar
                            </div>
                        </a>
                        @can('sell')
                            <a href="{{ route('product.edit', $data->id) }}">
                                <div class="btn btn-primary">
                                    <i class="fas fa-edit"></i> Editar
                                </div>
                            </a>
                            <a class="btn btn-danger btnDelete" id="{{ $data->id }}">
                                <div>
                                    <i class="fas fa-trash"></i> Deletar
                                </div>
                            </a>
                        @endcan
                    </td>
                </tr>
                <form action="{{ route('product.destroy', $data->id) }}" id="formDelete{{ $data->id }}" method="post">
                    @method('DELETE')
                    @csrf
                </form>
            @endforeach
        </table>
    </div>
@stop

@section('js')
    <script>

        $('.btnDelete').on('click', function() {
            const id = this.id;
            const req = confirm('Deseja deletar o produto de item #' + id.padStart(3, '0') + '?');

            if(req){
                $(`#formDelete${id}`).submit()
            }

        })

    </script>
@stop
