@extends('adminlte::page')

@section('title', 'Produtos - Visualização')

@section('content_header')
    <h1>
        Visualização de produtos
    </h1>
@stop

@section('content')
    <div class="class="container-fluid">

        <h3><strong>Código: </strong>{{ str_pad($data->id, 3, '0', STR_PAD_LEFT) }}</h3>
        <h3><strong>Nome: </strong>{{ $data->name }}</h3>
        <h3><strong>Preço: </strong>R$ {{ number_format($data->price, 2, ',', '.') }}</h3>
        <h3><strong>Quantidade: </strong>{{ $data->amount }}</h3>
        <h3><strong>Data de criação: </strong>{{ date('d/m/Y H:i:s', strtotime($data->created_at)) }}</h3>
        <h3><strong>Última atualização: </strong>{{ date('d/m/Y H:i:s', strtotime($data->updated_at)) }}</h3>

        <div class="form-group form-row">
            <div class="form-col">
                <a href="{{ route('products') }}" class="btn btn-primary">
                    <i class="fas fa-arrow-left"></i>
                    Voltar
                </a>
            </div>
            @can('sell')
                &nbsp;
                &nbsp;
                <div class="form-col">
                    <a class="btn btn-danger btnDelete" id="{{ $data->id }}">
                        <i class="fas fa-trash"></i>
                        Deletar
                    </a>
                </div>
            @endcan
        </div>

    </div>

    <form action="{{ route('product.destroy', $data->id) }}" id="formDelete{{ $data->id }}" method="post">
        @method('DELETE')
        @csrf
    </form>

@stop

@section('js')
    <script>

        $('.btnDelete').on('click', function() {
            const id  = this.id;
            const req = confirm('Deseja deletar o produto #' + id.padStart(4, '0') + '?');

            if(req){
                $(`#formDelete${id}`).submit()
            }

        })

    </script>
@stop

