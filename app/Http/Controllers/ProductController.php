<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\Product;

class ProductController extends Controller
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

        $datas = Product::orderBy('created_at', 'desc')->get();

        return view('pages.products.index', [ 'datas' => $datas]);

    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('pages.products.new');
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

        if(!$data){
            return redirect()->back()->withInput()->with('error', 'Houve um erro ao tentar cadastrar o produto, por favor verifique os valores inseridos!');
        }

        $data['name']  = ucfirst($data['name']);
        $data['price'] = str_replace(',', '.', str_replace('.', '', $data['price']));

        Product::create($data);

        return redirect()->route('products')->with('success', 'Produto cadastrado com sucesso!');

    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {

        $data = Product::find($id);

        return view('pages.products.show', [ 'data' => $data ]);

    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {

        $data = Product::find($id);

        $data["price"] = number_format($data['price'], 2, ',', '.');

        return view('pages.products.edit', [ 'data' => $data ]);

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

        $data = $request->except('_token', '_method');

        if(!$data){
            return redirect()->back()->withInput()->with('error', 'Houve um erro ao tentar cadastrar o produto, por favor verifique os valores inseridos!');
        }

        $product = Product::find($id);

        $product['name']   = ucfirst($request->name);
        $product['price']  = str_replace(',', '.', str_replace('.', '', $request->price));
        $product['amount'] = $request->amount;

        if(!$product->save()){
            return redirect()->back()->withInput()->with('error', 'Houve um erro ao tentar atualizar o produto, por favor verifique os valores inseridos!');
        }

        return redirect()->route('products')->with('success', "Produto com identificação {$id} atualizado com sucesso!");

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {

        Product::destroy($id);

        return redirect()->route('products')->with('success', "Item #" . str_pad($id, 3, '0', STR_PAD_LEFT) . " deletado com sucesso!");

    }
}
