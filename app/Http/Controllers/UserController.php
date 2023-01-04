<?php

namespace App\Http\Controllers;

use App\Models\User;
use Error;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {

        $users = User::orderBy('created_at', 'DESC')->get();

        return view('pages.users.index', [
            "datas" => $users,
        ]);

    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {

        return view('pages.users.new');

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

        if(strlen($data['password']) < 8){
            return redirect()->back()->withInput()->with('error', 'A senha deve ter no mínimo dígitos.');
        }

        if($data['password'] != $data['password_confirmation']){
            return redirect()->back()->withInput()->with('error', 'A senha não corresponde a confirmação de senha.');
        }

        $data['name']     = ucwords($data['name']);
        $data['password'] = Hash::make($data['password']);

        User::create($data);

        return redirect()->route('users')->with('success', 'Usuário cadastrado com sucesso!');

    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {

        $user = User::find($id);

        return view('pages.users.show', [
            'data' => $user,
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

        $user = User::find($id);

        return view('pages.users.edit', [
            'data' => $user,
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

        $user = User::find($id);

        $user['name']  = ucwords($data['name']);
        $user['email'] = $data['email'];
        $user['role']  = $data['role'];

        $user->save();

        return redirect()->route('users')->with('Usuário atualizado com sucesso!');

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {

        $user = User::find($id);

        $user->delete();

        return redirect()->route('users')->with('Usuário deletado com sucesso!');

    }
}
