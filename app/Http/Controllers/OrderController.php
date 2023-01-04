<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\Parcel;
use App\Models\Product;
use App\Models\User;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {

        $datas = Order::orderBy('created_at', 'desc')->with(['seller', 'client'])->get();

        return view('pages.orders.index', [ 'datas' => $datas ]);

    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {

        $clients = User::where('role', 'client')->get();
        $prods   = Product::all();

        return view('pages.orders.new', [
            'clients' => $clients,
            'prods' => $prods,
        ]);

    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {

        $data = $request->except('_token');

        $data['seller_id'] = Auth()->user()->id;
        $data['value']     = 0;

        foreach ($data['product_id'] as $id) {
            $prod = Product::find($id);
            $data['value'] += $prod->price;
        }

        $order = Order::create($data);

        $order->products()->sync($data['product_id']);

        if($data['parceled'] == 1){
            for ($i = 1; $i <= $data['amountParcels']; $i++) {
                Parcel::create([
                    "order_id"   => $order->id,
                    "value"      => str_replace(',', '.', str_replace('.', '', $data['value{$i}'])),
                    "expireDate" => $data["dataParcel{$i}"],
                    "obs"        => $data["obs{$i}"],
                ]);
            }
        }

        if(!$order->save()){
            return redirect()->back()->withInput()->with('error', 'Houve um erro ao tentar registrar a venda, por favor verifique os valores inseridos!');
        }

        return redirect()->route('orders')->with('success', 'Venda registrada com sucesso!');

    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {

        $order   = Order::with(['client', 'seller', 'products'])->find($id);
        $parcels = Parcel::where('order_id', $order->id)->orderBy('expireDate')->get();

        return view('pages.orders.show', [
            'data'    => $order,
            'parcels' => $parcels,
        ]);

    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $order   = Order::with(['client', 'products', 'parcels'])->find($id);
        $clients = User::where('role', 'client')->get();
        $prods   = Product::all();

        $ids     = [];
        $prodIds = [];

        foreach($order->parcels as $parc){
            $ids[] = $parc->id;
        }

        foreach($order->products as $prod){
            $prodIds[] = $prod->id;
        }

        return view('pages.orders.edit', [
            'data'    => $order,
            'clients' => $clients,
            'prods'   => $prods,
            'ids'     => $ids,
            'prodIds' => $prodIds,
        ]);

    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {

        $data = $request->except(['_token', '_method']);

        $data['value'] = 0;

        foreach ($data['product_id'] as $i) {
            $prod = Product::find($i);
            $data['value'] += $prod->price;
        }

        $order = Order::with(['products', 'parcels'])->find($id);

        $order['client_id']     = $data['client_id'];
        $order['methodPayment'] = $data['methodPayment'];
        $order['value']         = $data['value'];
        $order['parceled']      = $data['parceled'];

        $order->products()->sync($data['product_id']);

        foreach($order->parcels as $parcel){
            $parcel->delete();
        }

        if($data['parceled'] == 1){
            for ($i = 1; $i <= $data['amountParcels']; $i++) {
                Parcel::create([
                    "order_id"   => $order->id,
                    "value"      => str_replace(',', '.', str_replace('.', '', $data["value{$i}"])),
                    "expireDate" => $data["dataParcel{$i}"],
                    "obs"        => $data["obs{$i}"],
                ]);
            }
        }

        if(!$order->save()){
            return redirect()->back()->withInput()->with('error', 'Houve um erro ao tentar atualizar a venda, por favor verifique os valores inseridos!');
        }

        return redirect()->route('orders')->with('success', 'Venda atualizada com sucesso!');


    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {

        $order = Order::with(['products', 'parcels'])->find($id);

        $order->products()->sync([]);

        foreach($order->parcels as $parcel){
            $parcel->delete();
        }

        $order->delete();

        return redirect()->route('orders')->with('success', 'Vanda deletada com sucesso!');

    }
}
