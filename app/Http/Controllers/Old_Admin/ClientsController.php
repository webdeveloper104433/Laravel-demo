<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;

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

        return view('admin/clients/index', ['users' => $users, 'page_name' => self::PAGE_NAME]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin/clients/create', ['page_name' => self::PAGE_NAME]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        // $validator = $request->validate([
        //     'name' => ['required', 'string', 'max:255'],
        //     'description' => 'nullable|string',
        // ]);
        
        // $user = new User($request->all());

        // $user->save();

        $validator = $request->validate([
            'first_name' => 'required|string|max:255',
            'last_name' => 'required|string|max:255',
            'username' => 'required|string|max:255',
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'phone' => 'required|string|max:255',
            'gender' => 'required|boolean|max:255',
            'status' => 'required|boolean|max:255',
            'password' => ['required', 'string', 'min:8', 'confirmed'],
        ]);
        

        $user = new User($request->all());
        $user->description = $request->description;
        $user->status = $request->status;
        $user->password = Hash::make($request->password);
        $user->type = 'admin';
        $user->save();

        return redirect(route('admin.clients'))->with('success', 'A new client was created.');
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
            return redirect(route('admin.clients'))->with('warning', 'warning.');
        }

        return view('admin/clients/edit', ['user' => $user, 'page_name' => self::PAGE_NAME]);
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
        // $validator = $request->validate([
        //     'name' => [
        //                     'required',
        //                     'string',
        //                     'max:255',
        //                 ],
        //     'description' => 'nullable|string'
        // ]);
        
        // $user = User::find($id);

        // $user->fill($request->all());
        // $user->save();

        $validator = $request->validate([
            'first_name' => 'required|string|max:255',
            'last_name' => 'required|string|max:255',
            'username' => 'required|string|max:255',
            'email' => [
                            'required',
                            'string',
                            'email',
                            'max:255',
                            Rule::unique('users')->ignore($id),
                        ],
            'phone' => 'required|string|max:255',
            'gender' => 'required|boolean|max:255',
            'status' => 'required|boolean|max:255',
            // 'password' => ['nullable', 'string', 'min:8', 'confirmed'],
        ]);


        $user = User::find($id);
        $user->fill($request->all());

        $user->status = $request->status;
        // if ($request->password) {
        //     $user->password = Hash::make($request->password);
        // }

        return redirect(url('admin/clients/' . $id . '/edit'))->with('success', 'A client was updated.');
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
        return redirect(url('admin/clients'))->with('success', 'A client was deleted.');
    }
}
