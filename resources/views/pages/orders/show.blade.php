@extends('adminlte::page')

@section('title', 'Vendas    - Visualização')

@section('content_header')
    <h1>
        Visualização de vendas
    </h1>
@stop

@section('content')
    <div class="class="container-fluid">

        <h3><strong>Código: </strong>{{ str_pad($data->id, 4, '0', STR_PAD_LEFT) }}</h3>
        <h3><strong>Vendedor: </strong>{{ $data->seller->name }}</h3>
        <h3><strong>Cliente: </strong>{{ $data->client->name }}</h3>
        <h3><strong>Produtos: </strong>
            @foreach ($data->products as $key => $prod)
                {{ $prod->name }}
                @if ($key != (count($data->products) - 1))
                    ,
                @endif
            @endforeach
        </h3>
        <h3><strong>Método de pagamento: </strong>
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
        </h3>
        <h3><strong>Valor: </strong>R$ {{ number_format($data->value, 2, ',', '.') }}</h3>

        <h3><strong>Data de criação: </strong>{{ date('d/m/Y H:i:s', strtotime($data->created_at)) }}</h3>
        <h3><strong>Última atualização: </strong>{{ date('d/m/Y H:i:s', strtotime($data->updated_at)) }}</h3>

        @if (count($parcels) > 0)
            <h3><strong>Parcelas: </strong></h3>
            <table class="table table-striped col-6">
                <tr>
                    <th width='3%'>#</th>
                    <th width='7%'>Vencimento</th>
                    <th width='20%'>Valor</th>
                    <th>Obs</th>
                </tr>
                @php
                    $cont = 0
                @endphp
                @foreach ($parcels as $parc)
                    @php
                        $cont++
                    @endphp
                    <tr>
                        <td>{{ str_pad($cont, 2, '0', STR_PAD_LEFT) }}</td>
                        <td>{{ date('d/m/Y', strtotime($parc->expireDate)) }}</td>
                        <td>R$ {{ number_format($parc->value, 2, ',', '.') }}</td>
                        <td>{{ $parc->obs }}</td>
                    </tr>
                @endforeach
            </table>
        @endif

        <div class="form-group form-row">
            <div class="form-col">
                <a href="{{ route('orders') }}" class="btn btn-primary">
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

    <form action="{{ route('order.destroy', $data->id) }}" id="formDelete{{ $data->id }}" method="post">
        @method('DELETE')
        @csrf
    </form>

@stop

@section('js')
    <script>

        $('.btnDelete').on('click', function() {
            const id  = this.id;
            const req = confirm('Deseja deletar a venda #' + id.padStart(4, '0') + '?');

            if(req){
                $(`#formDelete${id}`).submit()
            }

        })

    </script>
@stop

