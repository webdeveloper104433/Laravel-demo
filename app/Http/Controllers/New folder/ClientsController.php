<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Client;
use App\User;
class ClientsController extends Controller
{
    const PAGE_NAME = "clients";

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('checkforsuperadmin');
        
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {

        $users = User::where('type', 'admin')->orderByDesc('id')->get();

        return view('clients/index', ['users' => $users, 'page_name' => self::PAGE_NAME]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('clients/create', ['page_name' => self::PAGE_NAME]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validator = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'description' => 'nullable|string',
        ]);
        
        $user = new User($request->all());

        $user->save();

        return redirect(route('clients'))->with('success', 'A new client was created.');
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
        
        if (empty($user)) {
            return redirect(route('clients'))->with('warning', 'warning.');
        }

        return view('clients/edit', ['user' => $user, 'page_name' => self::PAGE_NAME]);
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
        $validator = $request->validate([
            'name' => [
                            'required',
                            'string',
                            'max:255',
                        ],
            'description' => 'required|string'
        ]);
        
        $user = User::find($id);

        $user->fill($request->all());
        $user->save();

        return redirect(url('clients/' . $id . '/edit'))->with('success', 'A client was updated.');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        User::destroy($id);
        return redirect(url('clients'))->with('success', 'A client was deleted.');
    }
}
