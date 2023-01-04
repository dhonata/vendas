@extends('adminlte::page')

@section('title', 'Venda - Editar')

@section('content_header')
    <h1>Editar venda</h1>
@stop

@section('content')
    <div class="class="container-fluid">

        @include('includes.alerts')

        <form action="{{ route('order.update', $data->id) }}" method="post">

            @method('PUT')
            @csrf

            <div class="form-group">
                <label for="client">Cliente</label>
                <select required class="form-control" name="client_id" ">
                    <option value="">Selecione o cliente</option>
                    @foreach ($clients as $client)
                        <option {{ $data->client->id == $client->id ? 'selected' : '' }} value="{{ $client->id }}">{{ $client->name }}</option>
                    @endforeach
                </select>
            </div>

            <div class="form-group">
                <label>Método de pagamento</label>
                <div class="form-check">
                    <label class="form-check-label">
                        <input required type="radio" class="form-check-input" name="methodPayment" value="money" {{ $data->methodPayment == 'money' ? 'checked' : ''}}>
                        Dinheiro
                    </label>
                </div>
                <div class="form-check">
                    <label class="form-check-label">
                        <input required type="radio" class="form-check-input" name="methodPayment" value="card" {{ $data->methodPayment == 'card' ? 'checked' : ''}}>
                        Cartão
                    </label>
                </div>
                <div class="form-check">
                    <label class="form-check-label">
                        <input required type="radio" class="form-check-input" name="methodPayment" value="bankSlip" {{ $data->methodPayment == 'bankSlip' ? 'checked' : ''}}>
                        Boleto Bancario
                    </label>
                </div>
                <div class="form-check">
                    <label class="form-check-label">
                        <input required type="radio" class="form-check-input" name="methodPayment" value="pix" {{ $data->methodPayment == 'pix' ? 'checked' : ''}}>
                        Pix
                    </label>
                </div>
            </div>

            <div class="form-group">
                @php
                    $cont = 0
                @endphp
                @foreach ($prods as $prod)
                    @php
                        $cont ++
                    @endphp
                    @if ($cont > 3)
                        <br>
                        @php
                            $cont = 0
                        @endphp
                    @endif

                    <div class="form-check form-check-inline">
                        <label class="form-check-label">
                            <input class="form-check-input" type="checkbox" name="product_id[]" rel="{{ $prod->price }}" value="{{ $prod->id }}" {{ in_array($prod->id, $prodIds) ? 'checked' : '' }}> {{ $prod->name }}
                        </label>
                    </div>
                @endforeach
            </div>

            <div class="form-row form-group">
                <div class="col-2">
                    <label for="price">Preço</label>
                    <div class="input-group">
                        <div class="input-group-prepend">
                            <span class="input-group-text">R$</span>
                        </div>
                        <input type="text" value="0,00" id="price" class="form-control" placeholder="Preço" aria-describedby="preço" readonly>
                    </div>
                </div>
                <div class="col-1">
                    <label for="price">Parcelado?</label>
                    <select id="parcelQuest" name="parceled" class="form-control">
                        <option value="0" >Não</option>
                        <option value="1" {{ $data->parceled == 1 ? 'selected' : '' }}>Sim</option>
                    </select>
                </div>
                <div class="col-2 amountParcels">
                    <label for="price">Número de parcelas</label>
                    <input type="number" name="amountParcels" id="amountParcelsInput" class="form-control" value="{{ count($ids) }}" placeholder="número de parcelas" aria-describedby="número de parcelas">
                </div>
                <div class="col-2 amountParcels">
                    <button class="btn btn-info" type="button" onclick="generatePacels()" style="margin-top: 32px">
                        <i class="fas fa-file-medical"></i>
                        Crias Parcelas
                    </button>
                </div>
            </div>

            <div class="form-group parcelForm">
                @foreach($data->parcels as $i => $parcel)
                    <div class="form-row">
                        <div class="form-col-1" style="margin-top: 37px">
                            <label>{{ ($i + 1) }}</label>
                        </div>
                        <div class="form-col-3">
                            <label>Data</label>
                            <input  required type="date" class="form-control" name="dataParcel{{ ($i + 1) }}" value="{{ $parcel->expireDate }}">
                        </div>
                        <div class="form-col-3">
                            <label>Valor</label>
                            <input  required type="text" class="form-control" name="value{{ ($i + 1) }}" value="{{ number_format($parcel->value, 2, ',', '.') }}" placeholder="Valor">
                        </div>
                        <div class="form-col-3">
                            <label>Observação</label>
                            <input type="text" class="form-control" name="obs{{ ($i + 1) }}" value="{{ $parcel->obs ?? '' }}" placeholder="obs">
                        </div>
                    </div>
                @endforeach
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

@section('js')
    <script>

        if({{ count($ids) }} == 0){
            $('.amountParcels').hide(0)
        }

        setInterval(() => {
            let value = 0
            $('input[name="product_id[]"]:checked').toArray().map(function(check) {
                value += Number($(check).attr('rel'))
            });

            $('#price').val(value.toLocaleString('pt-br', {minimumFractionDigits: 2}));

        }, 1000);

        $('#parcelQuest').on('change', function() {
            if(this.value == 1){
                $('.amountParcels').show(100);
            }else{
                $('.amountParcels').hide(100);
            }
        })

        const generatePacels = () => {
            const parcels = $('#amountParcelsInput').val()
            const date = new Date();
            const valueTot = Number($('#price').val().replace('.', '').replace(',', '.'));
            console.log(valueTot);
            console.log(parcels);
            const valueParcel = Number((Number(valueTot) / Number(parcels)).toFixed(2)).toLocaleString('pt-br', {minimumFractionDigits: 2});
            let html = '';
            for(let i = 1; i <= parcels; i++){
                if(i == 1){
                    date.setDate(date.getDate() + 15);
                }else{
                    date.setMonth(date.getMonth() + 1);
                }
                let writeDate = date.getFullYear() + '-' + ((date.getMonth() + 1) < 10 ? '0' + (date.getMonth() + 1) : (date.getMonth() + 1)) + '-' + date.getDate();
                html += `
                    <div class="form-row">
                        <div class="form-col-1" style="margin-top: 37px">
                            <label>${i}</label>
                        </div>
                        <div class="form-col-3">
                            <label>Data</label>
                            <input  required type="date" class="form-control" name="dataParcel${i}" value="${writeDate}">
                        </div>
                        <div class="form-col-3">
                            <label>Valor</label>
                            <input  required type="text" class="form-control" name="value${i}" value="${valueParcel}" placeholder="Valor">
                        </div>
                        <div class="form-col-3">
                            <label>Observação</label>
                            <input type="text" class="form-control" name="obs${i}" placeholder="obs">
                        </div>
                    </div>
                `;
            }
            $('.parcelForm').html(html);
        }

    </script>
@stop
