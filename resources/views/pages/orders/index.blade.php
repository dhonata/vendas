@extends('adminlte::page')

@section('title', 'Vendas')

@section('content_header')
    <h1>
        Vendas
        @can('sell')
        |
            <a href="{{ route('order.new') }}">
                <div class="btn btn-success">
                    <i class="fas fa-plus"></i> Criar Venda
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
                    <th>Método de pagamento</th>
                    <th>Cliente</th>
                    <th>Vendedor</th>
                    <th>Ações</th>
                </tr>
            </thead>
            @foreach ($datas as $data)
                <tr>
                    <td>{{ str_pad($data->id, 4, '0', STR_PAD_LEFT) }}</td>
                    <td>
                        @switch($data->methodPayment)
                            @case('money')
                                Dinheiro
                                @break
                            @case('card')
                                Cartão
                                @break
                            @case('bankSlip')
                                Boleto bancario
                                @break
                            @case('pix')
                                Pix
                                @break
                        @endswitch
                    </td>
                    <td>{{ $data->client->name }}</td>
                    <td>{{ $data->seller->name }}</td>
                    <td width='25%' >
                        <a href="{{ route('order.show', $data->id) }}">
                            <div class="btn btn-success">
                                <i class="fas fa-eye"></i> Visualizar
                            </div>
                        </a>
                        <a href="{{ route('order.edit', $data->id) }}">
                            <div class="btn btn-primary">
                                <i class="fas fa-edit"></i> Editar
                            </div>
                        </a>
                        <a>
                            <div class="btn btn-danger btnDelete" id="{{ $data->id }}">
                                <i class="fas fa-trash"></i> Deletar
                            </div>
                        </a>
                    </td>
                </tr>
                <form action="{{ route('order.destroy', $data->id) }}" id="formDelete{{ $data->id }}" method="post">
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
            const req = confirm('Deseja deletar a venda #' + id.padStart(3, '0') + '?');

            if(req){
                $(`#formDelete${id}`).submit()
            }

        })

    </script>
@stop
